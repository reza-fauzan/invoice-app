@extends('layouts.app')

@section('title', 'Detail Invoice')

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Invoice {{ $invoice->nomor_invoice }}</h1>
            <p>Detail invoice pengiriman.</p>
        </div>
        <div class="page-header-actions" style="display: flex; gap: 8px;">
            <a href="{{ route('invoice.print', $invoice) }}" target="_blank" class="btn btn-secondary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 6 2 18 2 18 9"/>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8"/>
                </svg>
                Cetak
            </a>
            <a href="{{ route('invoice.edit', $invoice) }}" class="btn btn-primary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('invoice.index') }}" class="btn btn-secondary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Invoice Info --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div class="card">
            <h3 style="font-size: 14px; font-weight: 700; color: var(--color-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px;">Kepada Yth.</h3>
            <p style="font-size: 16px; font-weight: 700; color: var(--color-text); margin-bottom: 4px;">{{ $invoice->pelanggan->nama_pelanggan }}</p>
            <p style="font-size: 13px; color: var(--color-text-secondary); margin-bottom: 2px;">{{ $invoice->pelanggan->alamat }}</p>
            @if($invoice->pelanggan->npwp)
                <p style="font-size: 13px; color: var(--color-text-muted); margin-top: 8px;">NPWP: <span class="mono">{{ $invoice->pelanggan->npwp }}</span></p>
            @endif
        </div>
        <div class="card">
            <h3 style="font-size: 14px; font-weight: 700; color: var(--color-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px;">Info Invoice</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px 16px;">
                <div>
                    <p style="font-size: 12px; color: var(--color-text-muted);">No. Invoice</p>
                    <p class="mono" style="font-size: 14px; font-weight: 600; color: var(--color-text);">{{ $invoice->nomor_invoice }}</p>
                </div>
                <div>
                    <p style="font-size: 12px; color: var(--color-text-muted);">Status</p>
                    @php
                        $statusClass = match($invoice->status_pembayaran) {
                            'Paid' => 'badge-paid',
                            'Unpaid' => 'badge-unpaid',
                            'Draft' => 'badge-draft',
                            'Canceled' => 'badge-canceled',
                            default => 'badge-draft',
                        };
                    @endphp
                    <span class="badge {{ $statusClass }}" style="margin-top: 2px;">{{ $invoice->status_pembayaran }}</span>
                </div>
                <div>
                    <p style="font-size: 12px; color: var(--color-text-muted);">Tanggal Invoice</p>
                    <p style="font-size: 14px; font-weight: 500; color: var(--color-text);">{{ $invoice->tanggal_invoice->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p style="font-size: 12px; color: var(--color-text-muted);">Jatuh Tempo</p>
                    <p style="font-size: 14px; font-weight: 500; color: var(--color-text);">{{ $invoice->tanggal_jatuh_tempo ? $invoice->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Pengiriman --}}
    <div class="table-container" style="margin-bottom: 20px;">
        <div class="table-header">
            <h3>Detail Pengiriman</h3>
        </div>
        <div style="overflow-x: auto;">
            <table style="min-width: 1000px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>No Polisi</th>
                        <th>Penerima</th>
                        <th>SA NO</th>
                        <th>Srt Jalan</th>
                        <th>Tujuan</th>
                        <th>KET</th>
                        <th>Colly</th>
                        <th>Tonase</th>
                        <th>Satuan</th>
                        <th>Tarif/Kg</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->invoiceDetails as $i => $d)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $d->tanggal_kirim->format('d/m/Y') }}</td>
                            <td class="mono">{{ $d->no_pol ?? '-' }}</td>
                            <td>{{ $d->penerima ?? '-' }}</td>
                            <td class="mono">{{ $d->sa_no ?? '-' }}</td>
                            <td class="mono" style="font-size: 11px;">
                                @if($d->surat_jalan)
                                    @foreach(explode(',', $d->surat_jalan) as $sj)
                                        <div>{{ trim($sj) }}</div>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $d->tujuan ?? '-' }}</td>
                            <td>{{ $d->keterangan ?? '-' }}</td>
                            <td style="text-align: center;">{{ $d->colly ?? '-' }}</td>
                            <td class="mono">{{ number_format($d->tonase, 2, ',', '.') }}</td>
                            <td>{{ $d->satuan ?? 'Kg' }}</td>
                            <td class="mono">Rp {{ number_format($d->tarif, 0, ',', '.') }}</td>
                            <td class="mono" style="font-weight: 600; color: var(--color-text);">Rp {{ number_format($d->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="12" style="text-align: right; font-weight: 700; padding: 10px 16px;">Sub Total</td>
                        <td class="mono" style="font-weight: 700; padding: 10px 16px;">Rp {{ number_format($invoice->sub_total, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="12" style="text-align: right; font-size: 13px; color: var(--color-text-secondary); padding: 6px 16px;">DPP (11/12)</td>
                        <td class="mono" style="font-size: 13px; color: var(--color-text-secondary); padding: 6px 16px;">Rp {{ number_format($invoice->dpp, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="12" style="text-align: right; font-size: 13px; color: var(--color-text-secondary); padding: 6px 16px;">PPN 12% dari DPP</td>
                        <td class="mono" style="font-size: 13px; color: var(--color-text-secondary); padding: 6px 16px;">Rp {{ number_format($invoice->ppn, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="12" style="text-align: right; font-weight: 700; font-size: 16px; color: var(--color-primary); padding: 12px 16px; border-top: 2px solid var(--color-border);">Total</td>
                        <td class="mono" style="font-weight: 700; font-size: 16px; color: var(--color-primary); padding: 12px 16px; border-top: 2px solid var(--color-border);">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Pembayaran --}}
    @if($invoice->pembayarans->count())
        <div class="table-container">
            <div class="table-header">
                <h3>Riwayat Pembayaran</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->pembayarans as $bayar)
                        <tr>
                            <td>{{ $bayar->tanggal_bayar ? \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
                            <td class="mono" style="font-weight: 600; color: var(--color-text);">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ $bayar->metode_pembayaran ?? '-' }}</td>
                            <td>{{ $bayar->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
