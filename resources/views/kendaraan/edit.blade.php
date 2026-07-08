@extends('layouts.app')

@section('title', 'Edit Kendaraan')

@section('page-actions')
    <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary btn-sm">
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
        <form action="{{ route('kendaraan.update', $kendaraan) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: flex; flex-direction: column; gap: 20px;">
                {{-- No Pol & Jenis & Merk (3 kolom) --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div>
                        <label for="no_pol" class="form-label">No. Polisi <span style="color: var(--color-danger);">*</span></label>
                        <input type="text" name="no_pol" id="no_pol" class="form-input" placeholder="B 1234 XX" value="{{ old('no_pol', $kendaraan->no_pol) }}" required style="font-family: var(--font-mono); text-transform: uppercase;">
                        @error('no_pol')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-input">
                            <option value="">— Pilih Jenis —</option>
                            @foreach($jenisKendaraans as $jenis)
                                <option value="{{ $jenis->nama }}" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) == $jenis->nama ? 'selected' : '' }}>{{ $jenis->nama }}</option>
                            @endforeach
                        </select>
                        @error('jenis_kendaraan')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="merk" class="form-label">Merk</label>
                        <select name="merk" id="merk" class="form-input">
                            <option value="">— Pilih Merk —</option>
                            @foreach($merkKendaraans as $m)
                                <option value="{{ $m->nama }}" {{ old('merk', $kendaraan->merk) == $m->nama ? 'selected' : '' }}>{{ $m->nama }}</option>
                            @endforeach
                        </select>
                        @error('merk')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Tahun, Driver, Telp Driver, Status (4 kolom) --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 20px;">
                    <div>
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="text" name="tahun" id="tahun" class="form-input" placeholder="{{ date('Y') }}" value="{{ old('tahun', $kendaraan->tahun) }}" maxlength="4" style="font-family: var(--font-mono);">
                        @error('tahun')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="nama_driver" class="form-label">Nama Driver</label>
                        <input type="text" name="nama_driver" id="nama_driver" class="form-input" placeholder="Nama sopir" value="{{ old('nama_driver', $kendaraan->nama_driver) }}">
                        @error('nama_driver')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="no_telp_driver" class="form-label">Telp Driver</label>
                        <input type="text" name="no_telp_driver" id="no_telp_driver" class="form-input" placeholder="08xxxxxxxxxx" value="{{ old('no_telp_driver', $kendaraan->no_telp_driver) }}">
                        @error('no_telp_driver')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-input">
                            <option value="Aktif" {{ old('status', $kendaraan->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status', $kendaraan->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Keterangan --}}
                <div>
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-input" rows="3" placeholder="Catatan tambahan">{{ old('keterangan', $kendaraan->keterangan) }}</textarea>
                    @error('keterangan')
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
                        Update
                    </button>
                    <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
