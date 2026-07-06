@extends('layouts.app')

@section('title', 'Invoice')

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Invoice</h1>
            <p>Kelola semua invoice pengiriman.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('invoice.create') }}" class="btn btn-primary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Buat Invoice
            </a>
        </div>
    </div>

    {{-- Status Filter --}}
    <div style="display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap;">
        <a href="{{ route('invoice.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-secondary' }}">Semua</a>
        <a href="{{ route('invoice.index', ['status' => 'Draft']) }}" class="btn btn-sm {{ request('status') == 'Draft' ? 'btn-primary' : 'btn-secondary' }}">Draft</a>
        <a href="{{ route('invoice.index', ['status' => 'Unpaid']) }}" class="btn btn-sm {{ request('status') == 'Unpaid' ? 'btn-primary' : 'btn-secondary' }}">Unpaid</a>
        <a href="{{ route('invoice.index', ['status' => 'Paid']) }}" class="btn btn-sm {{ request('status') == 'Paid' ? 'btn-primary' : 'btn-secondary' }}">Paid</a>
        <a href="{{ route('invoice.index', ['status' => 'Canceled']) }}" class="btn btn-sm {{ request('status') == 'Canceled' ? 'btn-primary' : 'btn-secondary' }}">Canceled</a>
    </div>

    {{-- Table --}}
    <div class="table-container">
        <div class="table-header">
            <div>
                <h3>Daftar Invoice</h3>
                <p class="table-header-sub">Total: {{ $invoices->total() }} invoice</p>
            </div>
            <div class="table-actions">
                <form action="{{ route('invoice.index') }}" method="GET" style="display: flex; align-items: center;">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="search-inline">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" name="search" class="form-input" placeholder="Cari no. invoice atau pelanggan..." value="{{ request('search') }}" style="padding: 7px 12px 7px 34px; font-size: 13px; min-width: 260px;">
                    </div>
                </form>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Jatuh Tempo</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td class="mono" style="font-weight: 600; color: var(--color-text);">{{ $invoice->nomor_invoice }}</td>
                        <td style="font-weight: 500; color: var(--color-text);">{{ $invoice->pelanggan->nama_pelanggan }}</td>
                        <td>{{ $invoice->tanggal_invoice->format('d/m/Y') }}</td>
                        <td>{{ $invoice->tanggal_jatuh_tempo ? $invoice->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}</td>
                        <td class="mono" style="color: var(--color-text);">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $statusClass = match($invoice->status_pembayaran) {
                                    'Paid' => 'badge-paid',
                                    'Unpaid' => 'badge-unpaid',
                                    'Draft' => 'badge-draft',
                                    'Canceled' => 'badge-canceled',
                                    default => 'badge-draft',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $invoice->status_pembayaran }}</span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('invoice.show', $invoice) }}" class="btn-icon" title="Detail">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </a>
                                <a href="{{ route('invoice.edit', $invoice) }}" class="btn-icon" title="Edit">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('invoice.destroy', $invoice) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus invoice ini?')">
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
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                            <div style="font-size: 15px; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 4px;">Belum ada invoice</div>
                            <div style="font-size: 13px;">Buat invoice pertama Anda untuk memulai</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($invoices->hasPages())
            <div class="pagination-wrapper">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>
@endsection
