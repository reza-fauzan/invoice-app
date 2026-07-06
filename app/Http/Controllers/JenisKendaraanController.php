<?php

namespace App\Http\Controllers;

use App\Models\JenisKendaraan;
use Illuminate\Http\Request;

class JenisKendaraanController extends Controller
{
    public function index()
    {
        $items = JenisKendaraan::orderBy('nama')->get();
        return view('master.jenis-kendaraan', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_kendaraans,nama',
        ]);

        JenisKendaraan::create(['nama' => $request->nama]);

        return redirect()->route('jenis-kendaraan.index')
            ->with('success', 'Jenis kendaraan berhasil ditambahkan.');
    }

    public function update(Request $request, JenisKendaraan $jenis_kendaraan)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_kendaraans,nama,' . $jenis_kendaraan->id,
        ]);

        $jenis_kendaraan->update(['nama' => $request->nama]);

        return redirect()->route('jenis-kendaraan.index')
            ->with('success', 'Jenis kendaraan berhasil diperbarui.');
    }

    public function destroy(JenisKendaraan $jenis_kendaraan)
    {
        $jenis_kendaraan->delete();

        return redirect()->route('jenis-kendaraan.index')
            ->with('success', 'Jenis kendaraan berhasil dihapus.');
    }
}
