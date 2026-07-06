<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Tampilkan daftar invoice.
     */
    public function index(Request $request)
    {
        $query = Invoice::with('pelanggan');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_invoice', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function ($q2) use ($search) {
                      $q2->where('nama_pelanggan', 'like', "%{$search}%");
                  });
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        $invoices = $query->latest()->paginate(10)->withQueryString();

        return view('invoice.index', compact('invoices'));
    }

    /**
     * Tampilkan form buat invoice.
     */
    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();
        $produks = Produk::orderBy('nama_produk')->get();

        return view('invoice.create', compact('pelanggans', 'produks'));
    }

    /**
     * Simpan invoice baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id'      => 'required|exists:pelanggans,id',
            'tanggal_invoice'   => 'required|date',
            'status_pembayaran' => 'required|in:Draft,Unpaid,Paid,Canceled',
            'items'             => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty'       => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Generate nomor invoice: INV-YYYYMMDD-XXXX
            $today = now()->format('Ymd');
            $lastInvoice = Invoice::where('nomor_invoice', 'like', "INV-{$today}-%")
                ->orderBy('nomor_invoice', 'desc')
                ->first();

            if ($lastInvoice) {
                $lastNumber = (int) substr($lastInvoice->nomor_invoice, -4);
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }

            $nomorInvoice = "INV-{$today}-{$newNumber}";

            // Buat invoice
            $invoice = Invoice::create([
                'pelanggan_id'      => $validated['pelanggan_id'],
                'nomor_invoice'     => $nomorInvoice,
                'tanggal_invoice'   => $validated['tanggal_invoice'],
                'status_pembayaran' => $validated['status_pembayaran'],
                'total_tagihan'     => 0,
            ]);

            // Buat detail items
            $totalTagihan = 0;

            foreach ($request->items as $item) {
                $produk = Produk::find($item['produk_id']);
                $subtotal = $produk->harga * $item['qty'];
                $totalTagihan += $subtotal;

                InvoiceDetail::create([
                    'invoice_id'   => $invoice->id,
                    'produk_id'    => $item['produk_id'],
                    'qty'          => $item['qty'],
                    'harga_satuan' => $produk->harga,
                    'subtotal'     => $subtotal,
                ]);
            }

            // Update total tagihan
            $invoice->update(['total_tagihan' => $totalTagihan]);
        });

        return redirect()->route('invoice.index')
            ->with('success', 'Invoice berhasil dibuat.');
    }

    /**
     * Tampilkan detail invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['pelanggan', 'invoiceDetails.produk', 'pembayarans']);

        return view('invoice.show', compact('invoice'));
    }

    /**
     * Tampilkan form edit invoice.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load('invoiceDetails.produk');
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();
        $produks = Produk::orderBy('nama_produk')->get();

        return view('invoice.edit', compact('invoice', 'pelanggans', 'produks'));
    }

    /**
     * Update invoice.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'pelanggan_id'      => 'required|exists:pelanggans,id',
            'tanggal_invoice'   => 'required|date',
            'status_pembayaran' => 'required|in:Draft,Unpaid,Paid,Canceled',
            'items'             => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty'       => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated, $request, $invoice) {
            // Update invoice
            $invoice->update([
                'pelanggan_id'      => $validated['pelanggan_id'],
                'tanggal_invoice'   => $validated['tanggal_invoice'],
                'status_pembayaran' => $validated['status_pembayaran'],
            ]);

            // Hapus detail lama dan buat ulang
            $invoice->invoiceDetails()->delete();

            $totalTagihan = 0;

            foreach ($request->items as $item) {
                $produk = Produk::find($item['produk_id']);
                $subtotal = $produk->harga * $item['qty'];
                $totalTagihan += $subtotal;

                InvoiceDetail::create([
                    'invoice_id'   => $invoice->id,
                    'produk_id'    => $item['produk_id'],
                    'qty'          => $item['qty'],
                    'harga_satuan' => $produk->harga,
                    'subtotal'     => $subtotal,
                ]);
            }

            $invoice->update(['total_tagihan' => $totalTagihan]);
        });

        return redirect()->route('invoice.show', $invoice)
            ->with('success', 'Invoice berhasil diperbarui.');
    }

    /**
     * Hapus invoice.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoice.index')
            ->with('success', 'Invoice berhasil dihapus.');
    }
}
