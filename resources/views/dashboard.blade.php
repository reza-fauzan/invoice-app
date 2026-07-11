@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

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

    {{-- Charts Row 1: Omset vs Pembayaran & Proporsi Status --}}
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 24px;">
        {{-- Trend Chart --}}
        <div class="card" style="display: flex; flex-direction: column;">
            <div class="card-header" style="margin-bottom: 12px; padding: 0;">
                <div>
                    <h3 class="card-title">Tren Keuangan</h3>
                    <p class="card-subtitle">Omset Invoice vs Uang Masuk (6 Bulan Terakhir)</p>
                </div>
            </div>
            <div style="height: 280px; position: relative; flex: 1;">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        {{-- Status Breakdown Chart --}}
        <div class="card" style="display: flex; flex-direction: column;">
            <div class="card-header" style="margin-bottom: 12px; padding: 0;">
                <div>
                    <h3 class="card-title">Proporsi Status Tagihan</h3>
                    <p class="card-subtitle">Berdasarkan Status Invoice</p>
                </div>
            </div>
            <div style="height: 280px; position: relative; display: flex; align-items: center; justify-content: center; flex: 1;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Charts Row 2: Top Debtors & Recent Invoices --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
        {{-- Top Debtors Chart --}}
        <div class="card" style="display: flex; flex-direction: column;">
            <div class="card-header" style="margin-bottom: 12px; padding: 0;">
                <div>
                    <h3 class="card-title">Top 5 Piutang Pelanggan</h3>
                    <p class="card-subtitle">Nominal Tagihan Belum Lunas Terbesar</p>
                </div>
            </div>
            <div style="height: 280px; position: relative; flex: 1;">
                <canvas id="debtorsChart"></canvas>
            </div>
        </div>

        {{-- Recent Invoices Table --}}
        <div class="table-container" style="display: flex; flex-direction: column; justify-content: space-between; border-radius: 16px;">
            <div class="table-header" style="padding: 16px 20px 12px; border-bottom: 1px solid var(--color-border-light);">
                <div>
                    <h3 style="font-size: 16px; font-weight: 700;">Invoice Terbaru</h3>
                    <p class="table-header-sub">Riwayat Transaksi</p>
                </div>
                <div class="table-actions">
                    <a href="{{ route('invoice.index') }}" class="btn btn-secondary btn-sm" style="padding: 4px 10px; font-size: 11px;">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div style="flex: 1; overflow-x: auto;">
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="padding: 8px 12px; font-size: 10px;">No. Invoice</th>
                            <th style="padding: 8px 12px; font-size: 10px;">Pelanggan</th>
                            <th style="padding: 8px 12px; font-size: 10px;">Total</th>
                            <th style="padding: 8px 12px; font-size: 10px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentInvoices as $invoice)
                            @php
                                $isOverdue = $invoice->status_pembayaran === 'Unpaid' && $invoice->tanggal_jatuh_tempo && $invoice->tanggal_jatuh_tempo->lt(now()->startOfDay());
                            @endphp
                            <tr style="cursor: pointer; {{ $isOverdue ? 'background-color: rgba(239, 68, 68, 0.05); border-left: 3px solid var(--color-danger);' : '' }}" onclick="window.location='{{ route('invoice.show', $invoice) }}'">
                                <td class="mono" style="font-weight: 600; color: var(--color-text); padding: 8px 12px; font-size: 12px;">{{ $invoice->nomor_invoice }}</td>
                                <td style="font-weight: 500; color: var(--color-text); padding: 8px 12px; font-size: 12px; max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $invoice->pelanggan->nama_pelanggan }}">{{ $invoice->pelanggan->nama_pelanggan }}</td>
                                <td class="mono" style="color: var(--color-text); padding: 8px 12px; font-size: 12px;">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
                                <td style="padding: 8px 12px;">
                                    @php
                                        $statusClass = match($invoice->status_pembayaran) {
                                            'Paid' => 'badge-paid',
                                            'Unpaid' => 'badge-unpaid',
                                            'Draft' => 'badge-draft',
                                            'Canceled' => 'badge-canceled',
                                            default => 'badge-draft',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}" style="font-size: 10px; padding: 2px 6px;">{{ $invoice->status_pembayaran }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 32px 16px; color: var(--color-text-muted); font-size: 12px;">
                                    Belum ada invoice.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fontFamily = "'Inter', system-ui, -apple-system, sans-serif";
        const gridColor = 'rgba(156, 163, 175, 0.12)';
        const textColor = '#9CA3AF';

        // 1. Trend Chart (Omset vs Pembayaran)
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        const invoiceGrad = trendCtx.createLinearGradient(0, 0, 0, 260);
        invoiceGrad.addColorStop(0, 'rgba(79, 110, 247, 0.16)');
        invoiceGrad.addColorStop(1, 'rgba(79, 110, 247, 0)');
        
        const paymentGrad = trendCtx.createLinearGradient(0, 0, 0, 260);
        paymentGrad.addColorStop(0, 'rgba(34, 197, 94, 0.16)');
        paymentGrad.addColorStop(1, 'rgba(34, 197, 94, 0)');

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: @json(array_values($months)),
                datasets: [
                    {
                        label: 'Omset Invoice',
                        data: @json(array_values($invoiceMonthlyData)),
                        borderColor: '#4F6EF7',
                        backgroundColor: invoiceGrad,
                        fill: true,
                        tension: 0.3,
                        borderWidth: 2,
                        pointBackgroundColor: '#4F6EF7',
                        pointBorderColor: '#fff',
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Uang Masuk',
                        data: @json(array_values($paymentMonthlyData)),
                        borderColor: '#22C55E',
                        backgroundColor: paymentGrad,
                        fill: true,
                        tension: 0.3,
                        borderWidth: 2,
                        pointBackgroundColor: '#22C55E',
                        pointBorderColor: '#fff',
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { font: { family: fontFamily, size: 11 }, color: textColor, boxWidth: 10 }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: fontFamily, size: 10 }, color: textColor }
                    },
                    y: {
                        grid: { color: gridColor },
                        ticks: {
                            font: { family: fontFamily, size: 10 },
                            color: textColor,
                            callback: function(value) {
                                if (value >= 1e6) return 'Rp ' + (value / 1e6) + 'jt';
                                if (value >= 1e3) return 'Rp ' + (value / 1e3) + 'rb';
                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            }
        });

        // 2. Status Chart (Doughnut breakdown)
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Lunas', 'Belum Lunas', 'Draft', 'Dibatalkan'],
                datasets: [{
                    data: [
                        {{ $statusData['Paid'] }},
                        {{ $statusData['Unpaid'] }},
                        {{ $statusData['Draft'] }},
                        {{ $statusData['Canceled'] }}
                    ],
                    backgroundColor: ['#10B981', '#F43F5E', '#9CA3AF', '#F59E0B'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { family: fontFamily, size: 11, weight: '500' },
                            color: textColor,
                            padding: 16,
                            boxWidth: 6
                        }
                    }
                },
                cutout: '78%'
            },
            plugins: [{
                id: 'centerText',
                afterDraw(chart) {
                    const { ctx, chartArea: { top, bottom, left, right, width, height } } = chart;
                    ctx.save();
                    
                    const bodyColor = getComputedStyle(document.body).color || '#1F2937';
                    
                    ctx.font = "bold 24px 'Inter', sans-serif";
                    ctx.fillStyle = bodyColor;
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    
                    const total = {{ $statusData['Paid'] + $statusData['Unpaid'] + $statusData['Draft'] + $statusData['Canceled'] }};
                    ctx.fillText(total, left + width / 2, top + height / 2 - 8);
                    
                    ctx.font = "600 10px 'Inter', sans-serif";
                    ctx.fillStyle = '#9CA3AF';
                    ctx.fillText('TOTAL INVOICE', left + width / 2, top + height / 2 + 12);
                    ctx.restore();
                }
            }]
        });

        // 3. Debtors Chart (Horizontal Bar)
        const debtorsCtx = document.getElementById('debtorsChart').getContext('2d');
        new Chart(debtorsCtx, {
            type: 'bar',
            data: {
                labels: @json($topDebtors->pluck('nama')),
                datasets: [{
                    label: 'Piutang Belum Lunas',
                    data: @json($topDebtors->pluck('piutang')),
                    backgroundColor: 'rgba(79, 110, 247, 0.85)',
                    hoverBackgroundColor: '#4F6EF7',
                    borderRadius: 6,
                    borderWidth: 0,
                    barThickness: 14
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Piutang: Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: gridColor },
                        ticks: {
                            font: { family: fontFamily, size: 9 },
                            color: textColor,
                            callback: function(value) {
                                if (value >= 1e6) return (value / 1e6) + 'jt';
                                if (value >= 1e3) return (value / 1e3) + 'rb';
                                return value;
                            }
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { family: fontFamily, size: 10 }, color: textColor }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
