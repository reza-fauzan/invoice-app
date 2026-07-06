@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Tambah Pelanggan</h1>
            <p>Isi form di bawah untuk menambahkan pelanggan baru.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Form --}}
    <div class="card">
        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf

            <div style="display: flex; flex-direction: column; gap: 20px;">
                {{-- Nama --}}
                <div>
                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan <span style="color: var(--color-danger);">*</span></label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-input" placeholder="Masukkan nama pelanggan" value="{{ old('nama_pelanggan') }}" required>
                    @error('nama_pelanggan')
                        <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email, Telepon, NPWP (3 kolom) --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-input" placeholder="contoh@email.com" value="{{ old('email') }}">
                        @error('email')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" name="telepon" id="telepon" class="form-input" placeholder="08xxxxxxxxxx" value="{{ old('telepon') }}">
                        @error('telepon')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="npwp" class="form-label">NPWP 16</label>
                        <input type="text" name="npwp" id="npwp" class="form-input" placeholder="00000000000000000" value="{{ old('npwp') }}" style="font-family: var(--font-mono);">
                        @error('npwp')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Alamat --}}
                <div>
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-input" rows="4" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                    @error('alamat')
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
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
