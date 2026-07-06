@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Pembayaran</h1>
            <p>Kelola semua catatan pembayaran.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('pembayaran.create') }}" class="btn btn-primary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Catat Pembayaran
            </a>
        </div>
    </div>

    {{-- Status Filter --}}
    <div style="display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap;">
        <a href="{{ route('pembayaran.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-secondary' }}">Semua</a>
        <a href="{{ route('pembayaran.index', ['status' => 'Pending']) }}" class="btn btn-sm {{ request('status') == 'Pending' ? 'btn-primary' : 'btn-secondary' }}">Pending</a>
        <a href="{{ route('pembayaran.index', ['status' => 'Verified']) }}" class="btn btn-sm {{ request('status') == 'Verified' ? 'btn-primary' : 'btn-secondary' }}">Verified</a>
        <a href="{{ route('pembayaran.index', ['status' => 'Rejected']) }}" class="btn btn-sm {{ request('status') == 'Rejected' ? 'btn-primary' : 'btn-secondary' }}">Rejected</a>
    </div>

    {{-- Table --}}
    <div class="table-container">
        <div class="table-header">
            <div>
                <h3>Riwayat Pembayaran</h3>
                <p class="table-header-sub">Total: {{ $pembayarans->total() }} pembayaran</p>
            </div>
            <div class="table-actions">
                <form action="{{ route('pembayaran.index') }}" method="GET" style="display: flex; align-items: center;">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="search-inline">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" name="search" class="form-input" placeholder="Cari invoice atau pelanggan..." value="{{ request('search') }}" style="padding: 7px 12px 7px 34px; font-size: 13px; min-width: 260px;">
                    </div>
                </form>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Pelanggan</th>
                    <th>Tanggal Bayar</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayarans as $pembayaran)
                    <tr>
                        <td class="mono" style="font-weight: 600; color: var(--color-text);">
                            <a href="{{ route('invoice.show', $pembayaran->invoice_id) }}" style="color: var(--color-primary); text-decoration: none;">
                                {{ $pembayaran->invoice->nomor_invoice }}
                            </a>
                        </td>
                        <td style="font-weight: 500; color: var(--color-text);">{{ $pembayaran->invoice->pelanggan->nama_pelanggan }}</td>
                        <td>{{ $pembayaran->tanggal_bayar->format('d M Y') }}</td>
                        <td class="mono" style="font-weight: 600; color: var(--color-text);">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                        <td>{{ $pembayaran->metode_pembayaran }}</td>
                        <td>
                            @php
                                $statusClass = match($pembayaran->status_validasi) {
                                    'Verified' => 'badge-verified',
                                    'Pending' => 'badge-pending',
                                    'Rejected' => 'badge-rejected',
                                    default => 'badge-draft',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $pembayaran->status_validasi }}</span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('pembayaran.edit', $pembayaran) }}" class="btn-icon" title="Edit">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('pembayaran.destroy', $pembayaran) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pembayaran ini?')">
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
                        <td colspan="7" style="text-align: center; padding: 48px 24px; color: var(--color-text-muted);">
                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 14px; opacity: 0.35;">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                <line x1="1" y1="10" x2="23" y2="10"/>
                            </svg>
                            <div style="font-size: 15px; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 4px;">Belum ada pembayaran</div>
                            <div style="font-size: 13px;">Catat pembayaran pertama untuk memulai</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($pembayarans->hasPages())
            <div class="pagination-wrapper">
                {{ $pembayarans->links() }}
            </div>
        @endif
    </div>
@endsection
