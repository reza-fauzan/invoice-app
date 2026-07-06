@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Dashboard</h1>
            <p>Ringkasan data invoice dan pembayaran Anda.</p>
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

    {{-- KPI Cards --}}
    <div class="kpi-grid">
        {{-- Total Invoice --}}
        <div class="kpi-card">
            <div class="kpi-card-header">
                <div class="kpi-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
            </div>
            <div class="kpi-label">Total Invoice</div>
            <div class="kpi-value">{{ $totalInvoice }}</div>
        </div>

        {{-- Total Pelanggan --}}
        <div class="kpi-card">
            <div class="kpi-card-header">
                <div class="kpi-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                </div>
            </div>
            <div class="kpi-label">Total Pelanggan</div>
            <div class="kpi-value">{{ $totalPelanggan }}</div>
        </div>

        {{-- Belum Dibayar --}}
        <div class="kpi-card">
            <div class="kpi-card-header">
                <div class="kpi-icon red">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
            </div>
            <div class="kpi-label">Belum Dibayar</div>
            <div class="kpi-value">Rp {{ number_format($belumDibayar, 0, ',', '.') }}</div>
        </div>

        {{-- Sudah Dibayar --}}
        <div class="kpi-card">
            <div class="kpi-card-header">
                <div class="kpi-icon amber">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
            </div>
            <div class="kpi-label">Sudah Dibayar</div>
            <div class="kpi-value">Rp {{ number_format($sudahDibayar, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Recent Invoices Table --}}
    <div class="table-container">
        <div class="table-header">
            <div>
                <h3>Invoice Terbaru</h3>
                <p class="table-header-sub">Riwayat Transaksi</p>
            </div>
            <div class="table-actions">
                <a href="{{ route('invoice.index') }}" class="btn btn-secondary btn-sm">
                    Lihat Semua
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </a>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentInvoices as $invoice)
                    <tr style="cursor: pointer;" onclick="window.location='{{ route('invoice.show', $invoice) }}'">
                        <td class="mono" style="font-weight: 600; color: var(--color-text);">{{ $invoice->nomor_invoice }}</td>
                        <td style="font-weight: 500; color: var(--color-text);">{{ $invoice->pelanggan->nama_pelanggan }}</td>
                        <td>{{ $invoice->tanggal_invoice->format('d M Y') }}</td>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 48px 24px; color: var(--color-text-muted);">
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
    </div>
@endsection
