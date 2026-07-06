<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->nomor_invoice }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #000;
        }
        .invoice-container {
            width: 100%;
            max-width: 280mm;
            margin: 0 auto;
        }
        /* Header */
        .company-header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .company-address {
            font-size: 9px;
            margin-top: 2px;
        }
        .company-npwp {
            font-size: 9px;
            margin-top: 2px;
        }
        /* Info Row */
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .info-left {
            flex: 1;
        }
        .info-right {
            text-align: right;
            min-width: 180px;
        }
        .info-right table {
            margin-left: auto;
        }
        .info-right table td {
            padding: 1px 4px;
            font-size: 10px;
        }
        .info-right table td:first-child {
            text-align: right;
            font-weight: bold;
        }
        .customer-label {
            font-size: 10px;
        }
        .customer-name {
            font-size: 12px;
            font-weight: bold;
            margin-top: 2px;
        }
        .customer-address {
            font-size: 9px;
            max-width: 320px;
            line-height: 1.3;
            margin-top: 2px;
        }
        .customer-npwp {
            font-size: 9px;
            margin-top: 2px;
        }
        /* Table */
        .inv-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            font-size: 9px;
        }
        .inv-table th, .inv-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            vertical-align: top;
        }
        .inv-table th {
            background-color: #e8e8e8;
            font-weight: bold;
            text-align: center;
            font-size: 9px;
        }
        .inv-table td.num {
            text-align: right;
            font-family: 'Courier New', monospace;
        }
        .inv-table td.center {
            text-align: center;
        }
        .inv-table tfoot td {
            font-weight: bold;
        }
        /* Footer */
        .footer-row {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
        }
        .terbilang {
            font-size: 10px;
            margin-top: 6px;
            font-style: italic;
        }
        .terbilang span {
            font-weight: bold;
            color: red;
        }
        .payment-info {
            margin-top: 8px;
            font-size: 10px;
        }
        .payment-info strong {
            display: block;
            margin-bottom: 2px;
        }
        .signature {
            text-align: center;
            margin-top: 40px;
            font-size: 10px;
        }
        .signature .line {
            margin-top: 50px;
            border-top: 1px solid #000;
            display: inline-block;
            width: 150px;
        }
        .keterangan {
            margin-top: 10px;
            font-size: 8px;
            color: #444;
            border-top: 1px solid #999;
            padding-top: 4px;
        }
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none; }
        }
        .print-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px 24px;
            background: #4F6EF7;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            font-weight: 600;
            z-index: 100;
        }
        .print-btn:hover {
            background: #3d5bd9;
        }
    </style>
</head>
<body>
    <button class="print-btn no-print" onclick="window.print()">🖨 Cetak Invoice</button>

    <div class="invoice-container">
        {{-- Header Perusahaan --}}
        <div class="company-header">
            <div class="company-name">CV. SUMBER JAYA MAKMUR</div>
            <div class="company-address">JL. SIMOLAWANG BARU 3 NO.24 RT03/RW019 SIMOKERTO, KOTA SURABAYA, JAWA TIMUR</div>
            <div class="company-npwp">NPWP 16 : 0316566223604000</div>
        </div>

        {{-- Info Row --}}
        <div class="info-row">
            <div class="info-left">
                <div class="customer-label">Kepada Yth,</div>
                <div class="customer-name">{{ $invoice->pelanggan->nama_pelanggan }}</div>
                <div class="customer-address">{{ $invoice->pelanggan->alamat }}</div>
                @if($invoice->pelanggan->npwp)
                    <div class="customer-npwp">NPWP 16 : {{ $invoice->pelanggan->npwp }}</div>
                @endif
            </div>
            <div class="info-right">
                <table>
                    <tr><td>No-Invoice :</td><td>{{ $invoice->nomor_invoice }}</td></tr>
                    <tr><td>Tanggal :</td><td>{{ $invoice->tanggal_invoice->format('d/m/Y') }}</td></tr>
                    <tr><td>Tgl-Jth/Tmp :</td><td>{{ $invoice->tanggal_jatuh_tempo ? $invoice->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}</td></tr>
                </table>
            </div>
        </div>

        {{-- Detail Table --}}
        <table class="inv-table">
            <thead>
                <tr>
                    <th style="width: 25px;">NO</th>
                    <th style="width: 68px;">Tanggal</th>
                    <th style="width: 70px;">No-Pol</th>
                    <th>Penerima</th>
                    <th style="width: 70px;">SA NO</th>
                    <th style="width: 100px;">Srt Jalan</th>
                    <th style="width: 60px;">Tujuan</th>
                    <th style="width: 40px;">KET</th>
                    <th style="width: 35px;">Colly</th>
                    <th style="width: 65px;">Tonase</th>
                    <th style="width: 30px;">Sat</th>
                    <th style="width: 60px;">Tarif/Kg</th>
                    <th style="width: 80px;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->invoiceDetails as $i => $d)
                    <tr>
                        <td class="center">{{ $i + 1 }}</td>
                        <td class="center">{{ $d->tanggal_kirim->format('d/m/Y') }}</td>
                        <td>{{ $d->no_pol ?? '' }}</td>
                        <td>{{ $d->penerima ?? '' }}</td>
                        <td>{{ $d->sa_no ?? '' }}</td>
                        <td style="font-size: 8px;">{{ $d->surat_jalan ?? '' }}</td>
                        <td>{{ $d->tujuan ?? '' }}</td>
                        <td class="center">{{ $d->keterangan ?? '' }}</td>
                        <td class="center">{{ $d->colly ?? '' }}</td>
                        <td class="num">{{ number_format($d->tonase, 2, ',', '.') }}</td>
                        <td class="center">{{ $d->satuan ?? 'Kg' }}</td>
                        <td class="num">{{ number_format($d->tarif, 0, ',', '.') }}</td>
                        <td class="num">{{ number_format($d->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="12" style="text-align: right;">Sub Total</td>
                    <td class="num">Rp {{ number_format($invoice->sub_total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="12" style="text-align: right;">DPP 11/12</td>
                    <td class="num">Rp {{ number_format($invoice->dpp, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="12" style="text-align: right;">PPN 12% dari DPP 11/12</td>
                    <td class="num">Rp {{ number_format($invoice->ppn, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="12" style="text-align: right; font-size: 11px;">Total</td>
                    <td class="num" style="font-size: 11px;">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        {{-- Terbilang --}}
        @php
            function terbilang($angka) {
                $angka = abs(floor($angka));
                $huruf = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
                if ($angka < 12) return ' ' . $huruf[$angka];
                elseif ($angka < 20) return terbilang($angka - 10) . ' Belas';
                elseif ($angka < 100) return terbilang(floor($angka / 10)) . ' Puluh' . terbilang($angka % 10);
                elseif ($angka < 200) return ' Seratus' . terbilang($angka - 100);
                elseif ($angka < 1000) return terbilang(floor($angka / 100)) . ' Ratus' . terbilang($angka % 100);
                elseif ($angka < 2000) return ' Seribu' . terbilang($angka - 1000);
                elseif ($angka < 1000000) return terbilang(floor($angka / 1000)) . ' Ribu' . terbilang($angka % 1000);
                elseif ($angka < 1000000000) return terbilang(floor($angka / 1000000)) . ' Juta' . terbilang($angka % 1000000);
                elseif ($angka < 1000000000000) return terbilang(floor($angka / 1000000000)) . ' Miliar' . terbilang($angka % 1000000000);
                elseif ($angka < 1000000000000000) return terbilang(floor($angka / 1000000000000)) . ' Triliun' . terbilang($angka % 1000000000000);
                return '';
            }
        @endphp
        <div class="terbilang">
            Terbilang: <span># {{ trim(terbilang($invoice->total_tagihan)) }} Rupiah #</span>
        </div>

        {{-- Footer --}}
        <div class="footer-row">
            <div class="payment-info">
                <strong>Pembayaran ke :</strong>
                Ac : 7210223988<br>
                An : CV Sumber Jaya Makmur<br>
                Bank : BCA
            </div>
            <div class="signature">
                Hormat kami,
                <div class="line"></div>
            </div>
        </div>

        <div class="keterangan">
            <strong>Keterangan:</strong><br>
            Pelunasan sah setelah penerimaan giro / cek tersebut sudah clearing / insaan pada rekening kami.<br>
            Invoice / nota selalu dilampirkan dengan Surat Jalan / Surat Muat asli.
        </div>
    </div>
</body>
</html>
