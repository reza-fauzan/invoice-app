@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Total Invoice --}}
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-[24px] p-6 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-blue-500/10 transition-transform duration-700 group-hover:scale-[2.5] ease-out"></div>
            
            <div class="flex justify-between items-start mb-6 relative z-10">
                <div class="w-14 h-14 rounded-[18px] bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
            </div>
            
            <div class="relative z-10">
                <h3 class="text-3xl font-extrabold text-[var(--color-text)] tracking-tight mb-1">{{ $totalInvoice }}</h3>
                <p class="text-[14px] font-semibold text-[var(--color-text-secondary)]">Total Invoice</p>
            </div>
        </div>

        {{-- Total Pelanggan --}}
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-[24px] p-6 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-emerald-500/10 transition-transform duration-700 group-hover:scale-[2.5] ease-out"></div>
            
            <div class="flex justify-between items-start mb-6 relative z-10">
                <div class="w-14 h-14 rounded-[18px] bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                </div>
            </div>
            
            <div class="relative z-10">
                <h3 class="text-3xl font-extrabold text-[var(--color-text)] tracking-tight mb-1">{{ $totalPelanggan }}</h3>
                <p class="text-[14px] font-semibold text-[var(--color-text-secondary)]">Total Pelanggan</p>
            </div>
        </div>

        {{-- Belum Dibayar --}}
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-[24px] p-6 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-rose-500/10 transition-transform duration-700 group-hover:scale-[2.5] ease-out"></div>
            
            <div class="flex justify-between items-start mb-6 relative z-10">
                <div class="w-14 h-14 rounded-[18px] bg-rose-500/10 flex items-center justify-center text-rose-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
            </div>
            
            <div class="relative z-10">
                <h3 class="text-3xl font-extrabold text-[var(--color-text)] tracking-tight mb-1 flex items-baseline truncate">
                    <span class="text-[16px] text-[var(--color-text-muted)] font-bold mr-1">Rp</span>
                    {{ number_format($belumDibayar, 0, ',', '.') }}
                </h3>
                <p class="text-[14px] font-semibold text-[var(--color-text-secondary)]">Belum Dibayar</p>
            </div>
        </div>

        {{-- Sudah Dibayar --}}
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-[24px] p-6 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-amber-500/10 transition-transform duration-700 group-hover:scale-[2.5] ease-out"></div>
            
            <div class="flex justify-between items-start mb-6 relative z-10">
                <div class="w-14 h-14 rounded-[18px] bg-amber-500/10 flex items-center justify-center text-amber-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
            </div>
            
            <div class="relative z-10">
                <h3 class="text-3xl font-extrabold text-[var(--color-text)] tracking-tight mb-1 flex items-baseline truncate">
                    <span class="text-[16px] text-[var(--color-text-muted)] font-bold mr-1">Rp</span>
                    {{ number_format($sudahDibayar, 0, ',', '.') }}
                </h3>
                <p class="text-[14px] font-semibold text-[var(--color-text-secondary)]">Sudah Dibayar</p>
            </div>
        </div>
    </div>

    {{-- Charts Row 1: Omset vs Pembayaran & Proporsi Status --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Trend Chart --}}
        <div class="lg:col-span-2 bg-[var(--color-surface)] border border-[var(--color-border)] rounded-[24px] p-6 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col">
            <div class="mb-6">
                <h3 class="text-xl font-extrabold text-[var(--color-text)] tracking-tight mb-1">Tren Keuangan</h3>
                <p class="text-xs font-bold text-[var(--color-text-secondary)] uppercase tracking-widest">Omset Invoice vs Uang Masuk (6 Bulan Terakhir)</p>
            </div>
            <div style="height: 280px; position: relative; flex: 1;">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        {{-- Status Breakdown Chart --}}
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-[24px] p-6 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col">
            <div class="mb-6">
                <h3 class="text-xl font-extrabold text-[var(--color-text)] tracking-tight mb-1">Proporsi Status Tagihan</h3>
                <p class="text-xs font-bold text-[var(--color-text-secondary)] uppercase tracking-widest">Berdasarkan Status Invoice</p>
            </div>
            <div style="height: 280px; position: relative; display: flex; align-items: center; justify-content: center; flex: 1;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Charts Row 2: Top Debtors & Recent Invoices --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Top Debtors Chart --}}
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-[24px] p-6 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col">
            <div class="mb-6">
                <h3 class="text-xl font-extrabold text-[var(--color-text)] tracking-tight mb-1">Top 5 Piutang Pelanggan</h3>
                <p class="text-xs font-bold text-[var(--color-text-secondary)] uppercase tracking-widest">Nominal Tagihan Belum Lunas Terbesar</p>
            </div>
            <div style="height: 280px; position: relative; flex: 1;">
                <canvas id="debtorsChart"></canvas>
            </div>
        </div>

        {{-- Recent Invoices Table --}}
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-[24px] p-6 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-xl font-extrabold text-[var(--color-text)] tracking-tight mb-1">Invoice Terbaru</h3>
                    <p class="text-xs font-bold text-[var(--color-text-secondary)] uppercase tracking-widest">Riwayat Transaksi</p>
                </div>
                <a href="{{ route('invoice.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-[13px] font-bold rounded-xl transition-colors">
                    Lihat Semua
                </a>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="pb-3 pr-4 text-[11px] font-bold text-[var(--color-text-secondary)] uppercase tracking-widest border-b border-[var(--color-border)]">No. Invoice</th>
                            <th class="pb-3 px-4 text-[11px] font-bold text-[var(--color-text-secondary)] uppercase tracking-widest border-b border-[var(--color-border)]">Pelanggan</th>
                            <th class="pb-3 px-4 text-[11px] font-bold text-[var(--color-text-secondary)] uppercase tracking-widest border-b border-[var(--color-border)] text-right">Total</th>
                            <th class="pb-3 pl-4 text-[11px] font-bold text-[var(--color-text-secondary)] uppercase tracking-widest border-b border-[var(--color-border)] text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentInvoices as $invoice)
                            @php
                                $isOverdue = $invoice->status_pembayaran === 'Unpaid' && $invoice->tanggal_jatuh_tempo && $invoice->tanggal_jatuh_tempo->lt(now()->startOfDay());
                            @endphp
                            <tr class="group cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors border-b border-[var(--color-border)] last:border-0 {{ $isOverdue ? 'bg-red-50/50 dark:bg-red-900/10' : '' }}" onclick="window.location='{{ route('invoice.show', $invoice) }}'">
                                <td class="py-4 pr-4 font-bold text-[var(--color-text)] text-[13px] {{ $isOverdue ? 'border-l-2 border-red-500 pl-3 -ml-3' : '' }}">{{ $invoice->nomor_invoice }}</td>
                                <td class="py-4 px-4 font-semibold text-[var(--color-text-secondary)] text-[13px] truncate max-w-[120px]">{{ $invoice->pelanggan->nama_pelanggan }}</td>
                                <td class="py-4 px-4 font-bold text-[var(--color-text)] text-[13px] text-right whitespace-nowrap">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
                                <td class="py-4 pl-4 text-center">
                                    @php
                                        $statusClass = match($invoice->status_pembayaran) {
                                            'Paid' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
                                            'Unpaid' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400',
                                            'Draft' => 'bg-slate-100 text-slate-700 dark:bg-slate-500/20 dark:text-slate-400',
                                            'Canceled' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400',
                                            default => 'bg-slate-100 text-slate-700',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">
                                        {{ $invoice->status_pembayaran }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-[13px] font-semibold text-[var(--color-text-muted)]">
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
