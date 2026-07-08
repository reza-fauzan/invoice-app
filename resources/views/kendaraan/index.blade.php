@extends('layouts.app')

@section('title', 'Kendaraan')

@section('content')

    {{-- Status Filter & Actions Row --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        {{-- Filters (Left) --}}
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('kendaraan.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-secondary' }}">Semua</a>
            <a href="{{ route('kendaraan.index', ['status' => 'Aktif']) }}" class="btn btn-sm {{ request('status') == 'Aktif' ? 'btn-primary' : 'btn-secondary' }}">Aktif</a>
            <a href="{{ route('kendaraan.index', ['status' => 'Nonaktif']) }}" class="btn btn-sm {{ request('status') == 'Nonaktif' ? 'btn-primary' : 'btn-secondary' }}">Nonaktif</a>
        </div>

        {{-- Action Button (Right) --}}
        <div>
            <a href="{{ route('kendaraan.create') }}" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; font-size: 13px; height: 34px; line-height: 1;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Kendaraan
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-container">
        <div class="table-header">
            <div>
                <h3>Daftar Kendaraan</h3>
                <p class="table-header-sub">Total: {{ $kendaraans->total() }} kendaraan</p>
            </div>
            <div class="table-actions">
                <form action="{{ route('kendaraan.index') }}" method="GET" style="display: flex; align-items: center; margin: 0;">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="search-inline">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" name="search" class="form-input" placeholder="Cari no pol, jenis, driver..." value="{{ request('search') }}" style="padding: 7px 12px 7px 34px; font-size: 13px; min-width: 240px; height: 34px;">
                    </div>
                </form>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Polisi</th>
                    <th>Jenis</th>
                    <th>Merk</th>
                    <th>Tahun</th>
                    <th>Driver</th>
                    <th>Telp Driver</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kendaraans as $i => $k)
                    <tr>
                        <td>{{ $kendaraans->firstItem() + $i }}</td>
                        <td class="mono" style="font-weight: 600; color: var(--color-text); text-transform: uppercase;">{{ $k->no_pol }}</td>
                        <td>{{ $k->jenis_kendaraan ?? '-' }}</td>
                        <td>{{ $k->merk ?? '-' }}</td>
                        <td>{{ $k->tahun ?? '-' }}</td>
                        <td style="font-weight: 500; color: var(--color-text);">{{ $k->nama_driver ?? '-' }}</td>
                        <td class="mono">{{ $k->no_telp_driver ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $k->status == 'Aktif' ? 'badge-paid' : 'badge-canceled' }}">{{ $k->status }}</span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('kendaraan.edit', $k) }}" class="btn-icon" title="Edit">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('kendaraan.destroy', $k) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" title="Hapus" style="color: var(--color-danger);">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 48px 24px; color: var(--color-text-muted);">
                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 14px; opacity: 0.35;">
                                <rect x="1" y="3" width="15" height="13"/>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
                                <circle cx="5.5" cy="18.5" r="2.5"/>
                                <circle cx="18.5" cy="18.5" r="2.5"/>
                            </svg>
                            <div style="font-size: 15px; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 4px;">Belum ada kendaraan</div>
                            <div style="font-size: 13px;">Tambahkan kendaraan pertama Anda</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($kendaraans->hasPages())
            <div class="pagination-wrapper">
                {{ $kendaraans->links() }}
            </div>
        @endif
    </div>
@endsection
