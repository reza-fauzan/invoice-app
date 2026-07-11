<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use Illuminate\Http\Request;

class PenerimaController extends Controller
{
    public function index()
    {
        $items = Penerima::orderBy('nama')->get();
        return view('master.penerima', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:150|unique:penerimas,nama',
            'alamat'  => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
        ]);

        Penerima::create($request->only('nama', 'alamat', 'telepon'));

        return redirect()->route('penerima-master.index')
            ->with('success', 'Penerima berhasil ditambahkan.');
    }

    public function update(Request $request, Penerima $penerima_master)
    {
        $request->validate([
            'nama'    => 'required|string|max:150|unique:penerimas,nama,' . $penerima_master->id,
            'alamat'  => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
        ]);

        $penerima_master->update($request->only('nama', 'alamat', 'telepon'));

        return redirect()->route('penerima-master.index')
            ->with('success', 'Penerima berhasil diperbarui.');
    }

    public function destroy(Penerima $penerima_master)
    {
        $penerima_master->delete();

        return redirect()->route('penerima-master.index')
            ->with('success', 'Penerima berhasil dihapus.');
    }
}
