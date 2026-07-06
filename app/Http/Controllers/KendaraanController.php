<?php

namespace App\Http\Controllers;

use App\Models\JenisKendaraan;
use App\Models\Kendaraan;
use App\Models\MerkKendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    /**
     * Tampilkan daftar kendaraan.
     */
    public function index(Request $request)
    {
        $query = Kendaraan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_pol', 'like', "%{$search}%")
                  ->orWhere('jenis_kendaraan', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhere('nama_driver', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kendaraans = $query->latest()->paginate(10)->withQueryString();

        return view('kendaraan.index', compact('kendaraans'));
    }

    /**
     * Tampilkan form tambah kendaraan.
     */
    public function create()
    {
        $jenisKendaraans = JenisKendaraan::orderBy('nama')->get();
        $merkKendaraans = MerkKendaraan::orderBy('nama')->get();
        return view('kendaraan.create', compact('jenisKendaraans', 'merkKendaraans'));
    }

    /**
     * Simpan kendaraan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_pol'           => 'required|string|max:20|unique:kendaraans,no_pol',
            'jenis_kendaraan'  => 'nullable|string|max:100',
            'merk'             => 'nullable|string|max:100',
            'tahun'            => 'nullable|string|max:4',
            'nama_driver'      => 'nullable|string|max:100',
            'no_telp_driver'   => 'nullable|string|max:20',
            'status'           => 'required|in:Aktif,Nonaktif',
            'keterangan'       => 'nullable|string',
        ]);

        Kendaraan::create($validated);

        return redirect()->route('kendaraan.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit kendaraan.
     */
    public function edit(Kendaraan $kendaraan)
    {
        $jenisKendaraans = JenisKendaraan::orderBy('nama')->get();
        $merkKendaraans = MerkKendaraan::orderBy('nama')->get();
        return view('kendaraan.edit', compact('kendaraan', 'jenisKendaraans', 'merkKendaraans'));
    }

    /**
     * Update data kendaraan.
     */
    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'no_pol'           => 'required|string|max:20|unique:kendaraans,no_pol,' . $kendaraan->id,
            'jenis_kendaraan'  => 'nullable|string|max:100',
            'merk'             => 'nullable|string|max:100',
            'tahun'            => 'nullable|string|max:4',
            'nama_driver'      => 'nullable|string|max:100',
            'no_telp_driver'   => 'nullable|string|max:20',
            'status'           => 'required|in:Aktif,Nonaktif',
            'keterangan'       => 'nullable|string',
        ]);

        $kendaraan->update($validated);

        return redirect()->route('kendaraan.index')
            ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    /**
     * Hapus kendaraan.
     */
    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}
