@extends('layouts.app')

@section('title', 'Pelanggan')

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Pelanggan</h1>
            <p>Kelola data pelanggan Anda.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Pelanggan
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-container">
        <div class="table-header">
            <div>
                <h3>Daftar Pelanggan</h3>
                <p class="table-header-sub">Total: {{ $pelanggans->total() }} pelanggan</p>
            </div>
            <div class="table-actions">
                {{-- Search --}}
                <form action="{{ route('pelanggan.index') }}" method="GET" style="display: flex; align-items: center;">
                    <div class="search-inline">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" name="search" class="form-input" placeholder="Cari pelanggan..." value="{{ request('search') }}" style="padding: 7px 12px 7px 34px; font-size: 13px; min-width: 220px;">
                    </div>
                </form>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggans as $index => $pelanggan)
                    <tr>
                        <td>{{ $pelanggans->firstItem() + $index }}</td>
                        <td style="font-weight: 600; color: var(--color-text);">{{ $pelanggan->nama_pelanggan }}</td>
                        <td>{{ $pelanggan->email ?? '—' }}</td>
                        <td class="mono">{{ $pelanggan->telepon ?? '—' }}</td>
                        <td>{{ Str::limit($pelanggan->alamat, 40) ?? '—' }}</td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('pelanggan.edit', $pelanggan) }}" class="btn-icon" title="Edit">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('pelanggan.destroy', $pelanggan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
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
                        <td colspan="6" style="text-align: center; padding: 48px 24px; color: var(--color-text-muted);">
                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 14px; opacity: 0.35;">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                            </svg>
                            <div style="font-size: 15px; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 4px;">Belum ada pelanggan</div>
                            <div style="font-size: 13px;">Tambahkan pelanggan pertama Anda untuk memulai</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($pelanggans->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid var(--color-border); display: flex; justify-content: center;">
                {{ $pelanggans->links() }}
            </div>
        @endif
    </div>
@endsection
