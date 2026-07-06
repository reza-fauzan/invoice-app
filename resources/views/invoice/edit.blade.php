@extends('layouts.app')

@section('title', 'Edit Invoice')

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Edit Invoice</h1>
            <p>Ubah data invoice <strong>{{ $invoice->nomor_invoice }}</strong>.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('invoice.show', $invoice) }}" class="btn btn-secondary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('invoice.update', $invoice) }}" method="POST" id="invoiceForm">
        @csrf
        @method('PUT')

        {{-- Invoice Info --}}
        <div class="card" style="margin-bottom: 20px;">
            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: var(--color-text);">Informasi Invoice</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label for="pelanggan_id" class="form-label">Pelanggan (Kepada Yth.) <span style="color: var(--color-danger);">*</span></label>
                    <select name="pelanggan_id" id="pelanggan_id" class="form-input" required>
                        <option value="">— Pilih Pelanggan —</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id', $invoice->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                                {{ $pelanggan->nama_pelanggan }}
                            </option>
                        @endforeach
                    </select>
                    @error('pelanggan_id')
                        <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nomor_invoice" class="form-label">No. Invoice <span style="color: var(--color-danger);">*</span></label>
                    <input type="text" name="nomor_invoice" id="nomor_invoice" class="form-input" value="{{ old('nomor_invoice', $invoice->nomor_invoice) }}" required style="font-family: var(--font-mono);">
                    @error('nomor_invoice')
                        <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-top: 20px;">
                <div>
                    <label for="tanggal_invoice" class="form-label">Tanggal Invoice <span style="color: var(--color-danger);">*</span></label>
                    <input type="date" name="tanggal_invoice" id="tanggal_invoice" class="form-input" value="{{ old('tanggal_invoice', $invoice->tanggal_invoice->format('Y-m-d')) }}" required>
                </div>
                <div>
                    <label for="tanggal_jatuh_tempo" class="form-label">Tgl Jatuh Tempo</label>
                    <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" class="form-input" value="{{ old('tanggal_jatuh_tempo', $invoice->tanggal_jatuh_tempo?->format('Y-m-d')) }}">
                </div>
                <div>
                    <label for="status_pembayaran" class="form-label">Status <span style="color: var(--color-danger);">*</span></label>
                    <select name="status_pembayaran" id="status_pembayaran" class="form-input" required>
                        @foreach(['Draft','Unpaid','Paid','Canceled'] as $st)
                            <option value="{{ $st }}" {{ old('status_pembayaran', $invoice->status_pembayaran) == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Detail Pengiriman --}}
        <div class="card" style="margin-bottom: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <h3 style="font-size: 16px; font-weight: 700; color: var(--color-text);">Detail Pengiriman</h3>
                <button type="button" class="btn btn-primary btn-sm" onclick="addItem()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Baris
                </button>
            </div>

            <div style="overflow-x: auto;">
                <table id="itemsTable" style="min-width: 1100px;">
                    <thead>
                        <tr>
                            <th style="width: 110px;">Tanggal</th>
                            <th style="width: 90px;">No-Pol</th>
                            <th style="width: 140px;">Penerima</th>
                            <th style="width: 100px;">Srt Jalan</th>
                            <th style="width: 90px;">Tujuan</th>
                            <th style="width: 70px;">KET</th>
                            <th style="width: 60px;">Colly</th>
                            <th style="width: 90px;">Tonase</th>
                            <th style="width: 90px;">Tarif/Kg</th>
                            <th style="width: 100px;">Jumlah</th>
                            <th style="width: 40px;"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9" style="text-align: right; font-weight: 700; font-size: 14px; color: var(--color-text); padding: 10px 16px;">Sub Total</td>
                            <td class="mono" style="font-weight: 700; font-size: 14px; color: var(--color-text); padding: 10px 16px;" id="subTotal">Rp 0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="9" style="text-align: right; font-size: 13px; color: var(--color-text-secondary); padding: 6px 16px;">DPP (11/12)</td>
                            <td class="mono" style="font-size: 13px; color: var(--color-text-secondary); padding: 6px 16px;" id="dppTotal">Rp 0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="9" style="text-align: right; font-size: 13px; color: var(--color-text-secondary); padding: 6px 16px;">PPN 12% dari DPP</td>
                            <td class="mono" style="font-size: 13px; color: var(--color-text-secondary); padding: 6px 16px;" id="ppnTotal">Rp 0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="9" style="text-align: right; font-weight: 700; font-size: 16px; color: var(--color-primary); padding: 12px 16px; border-top: 2px solid var(--color-border);">Total</td>
                            <td class="mono" style="font-weight: 700; font-size: 16px; color: var(--color-primary); padding: 12px 16px; border-top: 2px solid var(--color-border);" id="grandTotal">Rp 0</td>
                            <td style="border-top: 2px solid var(--color-border);"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Update Invoice
            </button>
            <a href="{{ route('invoice.show', $invoice) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    let itemIndex = 0;
    const inputStyle = 'font-size: 12px; padding: 6px 8px;';

    function addItem(data = {}) {
        const tbody = document.getElementById('itemsBody');
        const row = document.createElement('tr');
        row.id = `item-row-${itemIndex}`;

        row.innerHTML = `
            <td style="padding: 6px 4px;"><input type="date" name="items[${itemIndex}][tanggal_kirim]" class="form-input" value="${data.tanggal_kirim || ''}" required style="${inputStyle}"></td>
            <td style="padding: 6px 4px;"><input type="text" name="items[${itemIndex}][no_pol]" class="form-input" value="${data.no_pol || ''}" placeholder="B 1234 XX" style="${inputStyle} text-transform: uppercase;"></td>
            <td style="padding: 6px 4px;"><input type="text" name="items[${itemIndex}][penerima]" class="form-input" value="${data.penerima || ''}" placeholder="Penerima" style="${inputStyle}"></td>
            <td style="padding: 6px 4px;"><input type="text" name="items[${itemIndex}][surat_jalan]" class="form-input" value="${data.surat_jalan || ''}" placeholder="No. SJ" style="${inputStyle} font-family: var(--font-mono);"></td>
            <td style="padding: 6px 4px;"><input type="text" name="items[${itemIndex}][tujuan]" class="form-input" value="${data.tujuan || ''}" placeholder="Kota" style="${inputStyle}"></td>
            <td style="padding: 6px 4px;"><input type="text" name="items[${itemIndex}][keterangan]" class="form-input" value="${data.keterangan || ''}" placeholder="KET" style="${inputStyle}"></td>
            <td style="padding: 6px 4px;"><input type="number" name="items[${itemIndex}][colly]" class="form-input" value="${data.colly || ''}" min="0" style="${inputStyle} text-align: center;"></td>
            <td style="padding: 6px 4px;"><input type="number" name="items[${itemIndex}][tonase]" class="form-input tonase-input" value="${data.tonase || ''}" step="0.01" min="0" required onchange="calcRow(${itemIndex})" oninput="calcRow(${itemIndex})" style="${inputStyle} font-family: var(--font-mono); text-align: right;"></td>
            <td style="padding: 6px 4px;"><input type="number" name="items[${itemIndex}][tarif]" class="form-input tarif-input" value="${data.tarif || ''}" step="0.01" min="0" required onchange="calcRow(${itemIndex})" oninput="calcRow(${itemIndex})" style="${inputStyle} font-family: var(--font-mono); text-align: right;"></td>
            <td style="padding: 6px 4px;"><span class="mono jumlah-display" id="jumlah-${itemIndex}" style="font-size: 12px; font-weight: 600; color: var(--color-text);">Rp 0</span></td>
            <td style="padding: 6px 4px; text-align: center;">
                <button type="button" class="btn-icon" onclick="removeItem(${itemIndex})" style="color: var(--color-danger); width: 28px; height: 28px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </td>
        `;
        const saInput = document.createElement('input');
        saInput.type = 'hidden'; saInput.name = `items[${itemIndex}][sa_no]`; saInput.value = data.sa_no || '';
        row.querySelector('td').appendChild(saInput);
        const satInput = document.createElement('input');
        satInput.type = 'hidden'; satInput.name = `items[${itemIndex}][satuan]`; satInput.value = data.satuan || 'Kg';
        row.querySelector('td').appendChild(satInput);
        tbody.appendChild(row);
        if (data.tonase && data.tarif) calcRow(itemIndex);
        itemIndex++;
    }

    function calcRow(idx) {
        const row = document.getElementById(`item-row-${idx}`);
        if (!row) return;
        const tonase = parseFloat(row.querySelector('.tonase-input').value) || 0;
        const tarif = parseFloat(row.querySelector('.tarif-input').value) || 0;
        document.getElementById(`jumlah-${idx}`).textContent = formatRp(tonase * tarif);
        calcTotals();
    }

    function removeItem(idx) { const row = document.getElementById(`item-row-${idx}`); if (row) { row.remove(); calcTotals(); } }

    function calcTotals() {
        let sub = 0;
        document.querySelectorAll('#itemsBody tr').forEach(row => {
            const t = parseFloat(row.querySelector('.tonase-input')?.value) || 0;
            const r = parseFloat(row.querySelector('.tarif-input')?.value) || 0;
            sub += t * r;
        });
        const dpp = sub * 11 / 12;
        const ppn = dpp * 0.12;
        document.getElementById('subTotal').textContent = formatRp(sub);
        document.getElementById('dppTotal').textContent = formatRp(Math.round(dpp));
        document.getElementById('ppnTotal').textContent = formatRp(Math.round(ppn));
        document.getElementById('grandTotal').textContent = formatRp(Math.round(dpp + ppn));
    }

    function formatRp(n) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(n)); }

    // Load existing items
    @foreach($invoice->invoiceDetails as $detail)
        addItem({
            tanggal_kirim: '{{ $detail->tanggal_kirim->format("Y-m-d") }}',
            no_pol: @json($detail->no_pol ?? ''),
            penerima: @json($detail->penerima ?? ''),
            sa_no: @json($detail->sa_no ?? ''),
            surat_jalan: @json($detail->surat_jalan ?? ''),
            tujuan: @json($detail->tujuan ?? ''),
            keterangan: @json($detail->keterangan ?? ''),
            colly: {{ $detail->colly ?? 'null' }},
            tonase: {{ $detail->tonase ?? 0 }},
            satuan: @json($detail->satuan ?? 'Kg'),
            tarif: {{ $detail->tarif ?? 0 }},
        });
    @endforeach
</script>
@endpush
