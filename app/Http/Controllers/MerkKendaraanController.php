<?php

namespace App\Http\Controllers;

use App\Models\MerkKendaraan;
use Illuminate\Http\Request;

class MerkKendaraanController extends Controller
{
    public function index()
    {
        $items = MerkKendaraan::orderBy('nama')->get();
        return view('master.merk-kendaraan', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:merk_kendaraans,nama',
        ]);

        MerkKendaraan::create(['nama' => $request->nama]);

        return redirect()->route('merk-kendaraan.index')
            ->with('success', 'Merk kendaraan berhasil ditambahkan.');
    }

    public function update(Request $request, MerkKendaraan $merk_kendaraan)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:merk_kendaraans,nama,' . $merk_kendaraan->id,
        ]);

        $merk_kendaraan->update(['nama' => $request->nama]);

        return redirect()->route('merk-kendaraan.index')
            ->with('success', 'Merk kendaraan berhasil diperbarui.');
    }

    public function destroy(MerkKendaraan $merk_kendaraan)
    {
        $merk_kendaraan->delete();

        return redirect()->route('merk-kendaraan.index')
            ->with('success', 'Merk kendaraan berhasil dihapus.');
    }
}
