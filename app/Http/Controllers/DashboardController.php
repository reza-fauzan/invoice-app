<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Pelanggan;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalInvoice = Invoice::count();
        $totalPelanggan = Pelanggan::count();

        $belumDibayar = Invoice::whereIn('status_pembayaran', ['Unpaid', 'Draft'])->sum('total_tagihan');
        $sudahDibayar = Invoice::where('status_pembayaran', 'Paid')->sum('total_tagihan');

        $overdueCount = Invoice::where('status_pembayaran', 'Unpaid')
            ->whereNotNull('tanggal_jatuh_tempo')
            ->where('tanggal_jatuh_tempo', '<', now()->toDateString())
            ->count();

        // 1. Data Trend Bulanan (6 Bulan Terakhir)
        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        $months = [];
        $invoiceMonthlyData = [];
        $paymentMonthlyData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $monthLabel = $monthNames[(int)$date->format('m')] . ' ' . $date->format('Y');
            
            $months[$monthKey] = $monthLabel;
            $invoiceMonthlyData[$monthKey] = 0;
            $paymentMonthlyData[$monthKey] = 0;
        }

        $invoicesLast6Months = Invoice::selectRaw("DATE_FORMAT(tanggal_invoice, '%Y-%m') as month, SUM(total_tagihan) as total")
            ->where('tanggal_invoice', '>=', now()->subMonths(5)->startOfMonth()->toDateString())
            ->groupBy('month')
            ->get();

        foreach ($invoicesLast6Months as $inv) {
            if (isset($invoiceMonthlyData[$inv->month])) {
                $invoiceMonthlyData[$inv->month] = (float) $inv->total;
            }
        }

        $paymentsLast6Months = Pembayaran::selectRaw("DATE_FORMAT(tanggal_bayar, '%Y-%m') as month, SUM(jumlah_bayar) as total")
            ->where('tanggal_bayar', '>=', now()->subMonths(5)->startOfMonth()->toDateString())
            ->groupBy('month')
            ->get();

        foreach ($paymentsLast6Months as $pay) {
            if (isset($paymentMonthlyData[$pay->month])) {
                $paymentMonthlyData[$pay->month] = (float) $pay->total;
            }
        }

        // 2. Data Status Pembayaran
        $statusCounts = Invoice::selectRaw('status_pembayaran, COUNT(*) as count')
            ->groupBy('status_pembayaran')
            ->pluck('count', 'status_pembayaran')
            ->toArray();
            
        $statusData = [
            'Paid' => $statusCounts['Paid'] ?? 0,
            'Unpaid' => $statusCounts['Unpaid'] ?? 0,
            'Draft' => $statusCounts['Draft'] ?? 0,
            'Canceled' => $statusCounts['Canceled'] ?? 0,
        ];

        // 3. Data Top 5 Piutang Pelanggan
        $topDebtors = Invoice::with('pelanggan')
            ->selectRaw('pelanggan_id, SUM(total_tagihan) as total_piutang')
            ->where('status_pembayaran', 'Unpaid')
            ->groupBy('pelanggan_id')
            ->orderBy('total_piutang', 'desc')
            ->take(5)
            ->get()
            ->map(fn($item) => [
                'nama' => $item->pelanggan->nama_pelanggan ?? 'Unknown',
                'piutang' => (float) $item->total_piutang
            ]);

        $recentInvoices = Invoice::with('pelanggan')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalInvoice',
            'totalPelanggan',
            'belumDibayar',
            'sudahDibayar',
            'recentInvoices',
            'overdueCount',
            'months',
            'invoiceMonthlyData',
            'paymentMonthlyData',
            'statusData',
            'topDebtors'
        ));
    }
}
