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
            <a href="#" class="btn btn-secondary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                30 Hari Terakhir
            </a>
            <a href="{{ url('/invoice') }}" class="btn btn-primary btn-sm">
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
                <span class="kpi-badge stable">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Stabil
                </span>
            </div>
            <div class="kpi-label">Total Invoice</div>
            <div class="kpi-value">0</div>
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
                <span class="kpi-badge up">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="18 15 12 9 6 15"/>
                    </svg>
                    0%
                </span>
            </div>
            <div class="kpi-label">Total Pelanggan</div>
            <div class="kpi-value">0</div>
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
                <span class="kpi-badge down">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                    0%
                </span>
            </div>
            <div class="kpi-label">Belum Dibayar</div>
            <div class="kpi-value">Rp 0<span class="unit"></span></div>
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
                <span class="kpi-badge up">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="18 15 12 9 6 15"/>
                    </svg>
                    0%
                </span>
            </div>
            <div class="kpi-label">Sudah Dibayar</div>
            <div class="kpi-value">Rp 0<span class="unit"></span></div>
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
                <button class="btn-icon" aria-label="Filter">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" y1="21" x2="4" y2="14"/>
                        <line x1="4" y1="10" x2="4" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12" y2="3"/>
                        <line x1="20" y1="21" x2="20" y2="16"/>
                        <line x1="20" y1="12" x2="20" y2="3"/>
                        <line x1="1" y1="14" x2="7" y2="14"/>
                        <line x1="9" y1="8" x2="15" y2="8"/>
                        <line x1="17" y1="16" x2="23" y2="16"/>
                    </svg>
                </button>
                <button class="btn-icon" aria-label="More">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="1"/>
                        <circle cx="12" cy="5" r="1"/>
                        <circle cx="12" cy="19" r="1"/>
                    </svg>
                </button>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 48px 24px; color: var(--color-text-muted);">
                        <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 14px; opacity: 0.35;">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        <div style="font-size: 15px; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 4px;">Belum ada invoice</div>
                        <div style="font-size: 13px;">Buat invoice pertama Anda untuk memulai</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
