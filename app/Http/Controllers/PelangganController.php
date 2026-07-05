<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Tampilkan daftar pelanggan.
     */
    public function index(Request $request)
    {
        $query = Pelanggan::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        $pelanggans = $query->latest()->paginate(10)->withQueryString();

        return view('pelanggan.index', compact('pelanggans'));
    }

    /**
     * Tampilkan form tambah pelanggan.
     */
    public function create()
    {
        return view('pelanggan.create');
    }

    /**
     * Simpan pelanggan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat'         => 'nullable|string',
            'telepon'        => 'nullable|string|max:20',
            'email'          => 'nullable|email|unique:pelanggans,email|max:255',
        ]);

        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit pelanggan.
     */
    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update data pelanggan.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat'         => 'nullable|string',
            'telepon'        => 'nullable|string|max:20',
            'email'          => 'nullable|email|unique:pelanggans,email,' . $pelanggan->id . '|max:255',
        ]);

        $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Hapus pelanggan.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        // Cek apakah pelanggan memiliki invoice
        if ($pelanggan->invoices()->exists()) {
            return redirect()->route('pelanggan.index')
                ->with('error', 'Pelanggan tidak bisa dihapus karena masih memiliki invoice.');
        }

        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
