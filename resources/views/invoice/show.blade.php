@extends('layouts.app')

@section('title', 'Detail Invoice')

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 style="display: flex; align-items: center; gap: 12px;">
                {{ $invoice->nomor_invoice }}
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
            </h1>
            <p>Detail invoice untuk {{ $invoice->pelanggan->nama_pelanggan }}.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('invoice.index') }}" class="btn btn-secondary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
            <a href="{{ route('invoice.edit', $invoice) }}" class="btn btn-primary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
        </div>
    </div>

    {{-- Invoice Info Cards --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px;">
        <div class="card">
            <div class="kpi-label" style="margin-bottom: 8px;">Pelanggan</div>
            <div style="font-weight: 700; font-size: 16px; color: var(--color-text); margin-bottom: 4px;">{{ $invoice->pelanggan->nama_pelanggan }}</div>
            @if($invoice->pelanggan->email)
                <div style="font-size: 13px; color: var(--color-text-secondary);">{{ $invoice->pelanggan->email }}</div>
            @endif
            @if($invoice->pelanggan->telepon)
                <div style="font-size: 13px; color: var(--color-text-secondary); font-family: var(--font-mono);">{{ $invoice->pelanggan->telepon }}</div>
            @endif
        </div>

        <div class="card">
            <div class="kpi-label" style="margin-bottom: 8px;">Tanggal Invoice</div>
            <div style="font-weight: 700; font-size: 16px; color: var(--color-text);">{{ $invoice->tanggal_invoice->format('d M Y') }}</div>
            <div style="font-size: 13px; color: var(--color-text-secondary); margin-top: 4px;">Dibuat {{ $invoice->created_at->diffForHumans() }}</div>
        </div>

        <div class="card">
            <div class="kpi-label" style="margin-bottom: 8px;">Total Tagihan</div>
            <div style="font-family: var(--font-mono); font-weight: 700; font-size: 24px; color: var(--color-primary);">
                Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}
            </div>
        </div>
    </div>

    {{-- Invoice Items --}}
    <div class="table-container" style="margin-bottom: 24px;">
        <div class="table-header">
            <div>
                <h3>Item Produk</h3>
                <p class="table-header-sub">{{ $invoice->invoiceDetails->count() }} item</p>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga Satuan</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->invoiceDetails as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style="font-weight: 600; color: var(--color-text);">{{ $detail->produk->nama_produk }}</td>
                        <td class="mono">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td class="mono">{{ $detail->qty }}</td>
                        <td class="mono" style="font-weight: 600; color: var(--color-text);">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: 700; font-size: 15px; color: var(--color-text); padding: 16px 24px; border-top: 2px solid var(--color-border);">
                        Total
                    </td>
                    <td style="font-family: var(--font-mono); font-weight: 700; font-size: 16px; color: var(--color-primary); padding: 16px 24px; border-top: 2px solid var(--color-border);">
                        Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Riwayat Pembayaran --}}
    <div class="table-container">
        <div class="table-header">
            <div>
                <h3>Riwayat Pembayaran</h3>
                <p class="table-header-sub">{{ $invoice->pembayarans->count() }} pembayaran</p>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoice->pembayarans as $pembayaran)
                    <tr>
                        <td>{{ $pembayaran->tanggal_bayar->format('d M Y') }}</td>
                        <td class="mono" style="font-weight: 600; color: var(--color-text);">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                        <td>{{ $pembayaran->metode_pembayaran }}</td>
                        <td>
                            @php
                                $valClass = match($pembayaran->status_validasi) {
                                    'Verified' => 'badge-verified',
                                    'Pending' => 'badge-pending',
                                    'Rejected' => 'badge-rejected',
                                    default => 'badge-draft',
                                };
                            @endphp
                            <span class="badge {{ $valClass }}">{{ $pembayaran->status_validasi }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 32px 24px; color: var(--color-text-muted);">
                            <div style="font-size: 14px;">Belum ada pembayaran untuk invoice ini.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
