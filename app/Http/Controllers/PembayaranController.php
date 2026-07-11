<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Tampilkan daftar pembayaran.
     */
    public function index(Request $request)
    {
        $query = Pembayaran::with('invoice.pelanggan');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('invoice', function ($q2) use ($search) {
                    $q2->where('nomor_invoice', 'like', "%{$search}%")
                       ->orWhereHas('pelanggan', function ($q3) use ($search) {
                           $q3->where('nama_pelanggan', 'like', "%{$search}%");
                       });
                })
                ->orWhere('metode_pembayaran', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status_validasi', $request->status);
        }

        $pembayarans = $query->latest()->paginate(10)->withQueryString();

        return view('pembayaran.index', compact('pembayarans'));
    }

    /**
     * Tampilkan form tambah pembayaran.
     */
    public function create(Request $request)
    {
        $invoices = Invoice::with('pelanggan')
            ->whereIn('status_pembayaran', ['Unpaid', 'Draft'])
            ->orderBy('nomor_invoice')
            ->get();

        $selectedInvoice = $request->invoice_id;

        return view('pembayaran.create', compact('invoices', 'selectedInvoice'));
    }

    /**
     * Simpan pembayaran baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id'         => 'required|exists:invoices,id',
            'tanggal_bayar'      => 'required|date',
            'jumlah_bayar'       => 'required|numeric|min:1',
            'metode_pembayaran'  => 'required|string|max:255',
            'bukti_bayar'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status_validasi'    => 'required|in:Pending,Verified,Rejected',
        ]);

        // Handle file upload
        $buktiBayar = null;
        if ($request->hasFile('bukti_bayar')) {
            $buktiBayar = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
        }

        Pembayaran::create([
            'invoice_id'        => $validated['invoice_id'],
            'tanggal_bayar'     => $validated['tanggal_bayar'],
            'jumlah_bayar'      => $validated['jumlah_bayar'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'bukti_bayar'       => $buktiBayar,
            'status_validasi'   => $validated['status_validasi'],
        ]);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dicatat.');
    }

    /**
     * Tampilkan form edit pembayaran.
     */
    public function edit(Pembayaran $pembayaran)
    {
        $pembayaran->load('invoice.pelanggan');
        $invoices = Invoice::with('pelanggan')->orderBy('nomor_invoice')->get();

        return view('pembayaran.edit', compact('pembayaran', 'invoices'));
    }

    /**
     * Update pembayaran.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'invoice_id'         => 'required|exists:invoices,id',
            'tanggal_bayar'      => 'required|date',
            'jumlah_bayar'       => 'required|numeric|min:1',
            'metode_pembayaran'  => 'required|string|max:255',
            'bukti_bayar'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status_validasi'    => 'required|in:Pending,Verified,Rejected',
        ]);

        $data = [
            'invoice_id'        => $validated['invoice_id'],
            'tanggal_bayar'     => $validated['tanggal_bayar'],
            'jumlah_bayar'      => $validated['jumlah_bayar'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'status_validasi'   => $validated['status_validasi'],
        ];

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
        }

        $pembayaran->update($data);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil diperbarui.');
    }

    /**
     * Hapus pembayaran.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }
}
