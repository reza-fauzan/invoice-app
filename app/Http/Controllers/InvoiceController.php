<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Pelanggan;
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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_invoice', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function ($q2) use ($search) {
                      $q2->where('nama_pelanggan', 'like', "%{$search}%");
                  });
            });
        }

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

        return view('invoice.create', compact('pelanggans'));
    }

    /**
     * Simpan invoice baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id'        => 'required|exists:pelanggans,id',
            'nomor_invoice'       => 'required|string|max:50|unique:invoices,nomor_invoice',
            'tanggal_invoice'     => 'required|date',
            'tanggal_jatuh_tempo' => 'nullable|date',
            'status_pembayaran'   => 'required|in:Draft,Unpaid,Paid,Canceled',
            'items'               => 'required|array|min:1',
            'items.*.tanggal_kirim' => 'required|date',
            'items.*.no_pol'      => 'nullable|string|max:20',
            'items.*.penerima'    => 'nullable|string|max:255',
            'items.*.sa_no'       => 'nullable|string|max:50',
            'items.*.surat_jalan' => 'nullable|string',
            'items.*.tujuan'      => 'nullable|string|max:100',
            'items.*.keterangan'  => 'nullable|string|max:100',
            'items.*.colly'       => 'nullable|integer|min:0',
            'items.*.tonase'      => 'required|numeric|min:0',
            'items.*.satuan'      => 'nullable|string|max:20',
            'items.*.tarif'       => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $subTotal = 0;

            // Hitung sub total
            foreach ($request->items as $item) {
                $jumlah = ($item['tonase'] ?? 0) * ($item['tarif'] ?? 0);
                $subTotal += $jumlah;
            }

            // Hitung DPP dan PPN
            $dpp = $subTotal * 11 / 12;
            $ppn = $dpp * 0.12;
            $totalTagihan = $subTotal + $ppn - ($subTotal - $dpp); // = dpp + ppn = sub_total

            $invoice = Invoice::create([
                'pelanggan_id'        => $validated['pelanggan_id'],
                'nomor_invoice'       => $validated['nomor_invoice'],
                'tanggal_invoice'     => $validated['tanggal_invoice'],
                'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'] ?? null,
                'status_pembayaran'   => $validated['status_pembayaran'],
                'sub_total'           => $subTotal,
                'dpp'                 => round($dpp),
                'ppn'                 => round($ppn),
                'total_tagihan'       => round($dpp + $ppn),
            ]);

            foreach ($request->items as $item) {
                $jumlah = ($item['tonase'] ?? 0) * ($item['tarif'] ?? 0);

                InvoiceDetail::create([
                    'invoice_id'    => $invoice->id,
                    'tanggal_kirim' => $item['tanggal_kirim'],
                    'no_pol'        => $item['no_pol'] ?? null,
                    'penerima'      => $item['penerima'] ?? null,
                    'sa_no'         => $item['sa_no'] ?? null,
                    'surat_jalan'   => $item['surat_jalan'] ?? null,
                    'tujuan'        => $item['tujuan'] ?? null,
                    'keterangan'    => $item['keterangan'] ?? null,
                    'colly'         => $item['colly'] ?? null,
                    'tonase'        => $item['tonase'] ?? 0,
                    'satuan'        => $item['satuan'] ?? 'Kg',
                    'tarif'         => $item['tarif'] ?? 0,
                    'jumlah'        => $jumlah,
                ]);
            }
        });

        return redirect()->route('invoice.index')
            ->with('success', 'Invoice berhasil dibuat.');
    }

    /**
     * Tampilkan detail invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['pelanggan', 'invoiceDetails', 'pembayarans']);

        return view('invoice.show', compact('invoice'));
    }

    /**
     * Tampilkan form edit invoice.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load('invoiceDetails');
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();

        return view('invoice.edit', compact('invoice', 'pelanggans'));
    }

    /**
     * Update invoice.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'pelanggan_id'        => 'required|exists:pelanggans,id',
            'nomor_invoice'       => 'required|string|max:50|unique:invoices,nomor_invoice,' . $invoice->id,
            'tanggal_invoice'     => 'required|date',
            'tanggal_jatuh_tempo' => 'nullable|date',
            'status_pembayaran'   => 'required|in:Draft,Unpaid,Paid,Canceled',
            'items'               => 'required|array|min:1',
            'items.*.tanggal_kirim' => 'required|date',
            'items.*.no_pol'      => 'nullable|string|max:20',
            'items.*.penerima'    => 'nullable|string|max:255',
            'items.*.sa_no'       => 'nullable|string|max:50',
            'items.*.surat_jalan' => 'nullable|string',
            'items.*.tujuan'      => 'nullable|string|max:100',
            'items.*.keterangan'  => 'nullable|string|max:100',
            'items.*.colly'       => 'nullable|integer|min:0',
            'items.*.tonase'      => 'required|numeric|min:0',
            'items.*.satuan'      => 'nullable|string|max:20',
            'items.*.tarif'       => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $request, $invoice) {
            $subTotal = 0;

            foreach ($request->items as $item) {
                $jumlah = ($item['tonase'] ?? 0) * ($item['tarif'] ?? 0);
                $subTotal += $jumlah;
            }

            $dpp = $subTotal * 11 / 12;
            $ppn = $dpp * 0.12;

            $invoice->update([
                'pelanggan_id'        => $validated['pelanggan_id'],
                'nomor_invoice'       => $validated['nomor_invoice'],
                'tanggal_invoice'     => $validated['tanggal_invoice'],
                'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'] ?? null,
                'status_pembayaran'   => $validated['status_pembayaran'],
                'sub_total'           => $subTotal,
                'dpp'                 => round($dpp),
                'ppn'                 => round($ppn),
                'total_tagihan'       => round($dpp + $ppn),
            ]);

            $invoice->invoiceDetails()->delete();

            foreach ($request->items as $item) {
                $jumlah = ($item['tonase'] ?? 0) * ($item['tarif'] ?? 0);

                InvoiceDetail::create([
                    'invoice_id'    => $invoice->id,
                    'tanggal_kirim' => $item['tanggal_kirim'],
                    'no_pol'        => $item['no_pol'] ?? null,
                    'penerima'      => $item['penerima'] ?? null,
                    'sa_no'         => $item['sa_no'] ?? null,
                    'surat_jalan'   => $item['surat_jalan'] ?? null,
                    'tujuan'        => $item['tujuan'] ?? null,
                    'keterangan'    => $item['keterangan'] ?? null,
                    'colly'         => $item['colly'] ?? null,
                    'tonase'        => $item['tonase'] ?? 0,
                    'satuan'        => $item['satuan'] ?? 'Kg',
                    'tarif'         => $item['tarif'] ?? 0,
                    'jumlah'        => $jumlah,
                ]);
            }
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

    /**
     * Cetak invoice.
     */
    public function print(Invoice $invoice)
    {
        $invoice->load(['pelanggan', 'invoiceDetails']);

        return view('invoice.print', compact('invoice'));
    }
}
