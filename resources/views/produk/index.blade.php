@extends('layouts.app')

@section('title', 'Produk')

@section('content')
    {{-- Table --}}
    <div class="table-container">
        <div class="table-header">
            <div>
                <h3>Daftar Produk</h3>
                <p class="table-header-sub">Total: {{ $produks->total() }} produk</p>
            </div>
            <div class="table-actions" style="display: flex; align-items: center; gap: 12px;">
                <form action="{{ route('produk.index') }}" method="GET" style="display: flex; align-items: center; margin: 0;">
                    <div class="search-inline">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" name="search" class="form-input" placeholder="Cari produk..." value="{{ request('search') }}" style="padding: 7px 12px 7px 34px; font-size: 13px; min-width: 220px; height: 34px;">
                    </div>
                </form>

                <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; font-size: 13px; height: 34px; line-height: 1;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Produk
                </a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produks as $index => $produk)
                    <tr>
                        <td>{{ $produks->firstItem() + $index }}</td>
                        <td style="font-weight: 600; color: var(--color-text);">{{ $produk->nama_produk }}</td>
                        <td class="mono" style="color: var(--color-text);">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>{{ $produk->created_at->format('d M Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('produk.edit', $produk) }}" class="btn-icon" title="Edit">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('produk.destroy', $produk) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
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
                        <td colspan="5" style="text-align: center; padding: 48px 24px; color: var(--color-text-muted);">
                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 14px; opacity: 0.35;">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                                <line x1="12" y1="22.08" x2="12" y2="12"/>
                            </svg>
                            <div style="font-size: 15px; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 4px;">Belum ada produk</div>
                            <div style="font-size: 13px;">Tambahkan produk pertama Anda untuk memulai</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($produks->hasPages())
            <div class="pagination-wrapper">
                {{ $produks->links() }}
            </div>
        @endif
    </div>
@endsection
