<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Pelanggan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalInvoice = Invoice::count();
        $totalPelanggan = Pelanggan::count();

        $belumDibayar = Invoice::whereIn('status_pembayaran', ['Unpaid', 'Draft'])->sum('total_tagihan');
        $sudahDibayar = Invoice::where('status_pembayaran', 'Paid')->sum('total_tagihan');

        $recentInvoices = Invoice::with('pelanggan')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalInvoice',
            'totalPelanggan',
            'belumDibayar',
            'sudahDibayar',
            'recentInvoices'
        ));
    }
}
