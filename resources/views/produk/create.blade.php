@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('page-actions')
    <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')

    {{-- Form --}}
    <div class="card">
        <form action="{{ route('produk.store') }}" method="POST">
            @csrf

            <div style="display: flex; flex-direction: column; gap: 20px;">
                {{-- Nama Produk --}}
                <div>
                    <label for="nama_produk" class="form-label">Nama Produk <span style="color: var(--color-danger);">*</span></label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-input" placeholder="Masukkan nama produk" value="{{ old('nama_produk') }}" required>
                    @error('nama_produk')
                        <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label for="harga" class="form-label">Harga (Rp) <span style="color: var(--color-danger);">*</span></label>
                    <input type="number" name="harga" id="harga" class="form-input" placeholder="0" value="{{ old('harga') }}" min="0" step="0.01" required style="font-family: var(--font-mono);">
                    @error('harga')
                        <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div style="display: flex; gap: 10px; padding-top: 8px;">
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan
                    </button>
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
