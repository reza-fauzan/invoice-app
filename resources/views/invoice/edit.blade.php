@extends('layouts.app')

@section('title', 'Edit Invoice')

@section('page-actions')
    <a href="{{ route('invoice.show', $invoice) }}" class="btn btn-secondary btn-sm">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')

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

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                <div>
                    <label for="tanggal_invoice" class="form-label">Tanggal Invoice <span style="color: var(--color-danger);">*</span></label>
                    <input type="date" name="tanggal_invoice" id="tanggal_invoice" class="form-input" value="{{ old('tanggal_invoice', $invoice->tanggal_invoice->format('Y-m-d')) }}" required>
                </div>
                <div>
                    <label for="tanggal_jatuh_tempo" class="form-label">Tgl Jatuh Tempo</label>
                    <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" class="form-input" value="{{ old('tanggal_jatuh_tempo', $invoice->tanggal_jatuh_tempo?->format('Y-m-d')) }}">
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

            <div style="overflow-x: auto; overflow-y: visible; position: relative;">
                <table id="itemsTable" style="min-width: 1300px;">
                    <thead>
                        <tr>
                            <th style="width: 110px;">Tanggal</th>
                            <th style="width: 130px;">No Polisi</th>
                            <th style="width: 130px;">Penerima</th>
                            <th style="width: 90px;">SA NO</th>
                            <th style="width: 160px;">Srt Jalan</th>
                            <th style="width: 90px;">Tujuan</th>
                            <th style="width: 70px;">KET</th>
                            <th style="width: 60px;">Colly</th>
                            <th style="width: 90px;">Tonase</th>
                            <th style="width: 80px;">Satuan</th>
                            <th style="width: 90px;">Tarif/Kg</th>
                            <th style="width: 110px;">Jumlah</th>
                            <th style="width: 40px;"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="11" style="text-align: right; font-weight: 700; font-size: 14px; color: var(--color-text); padding: 10px 16px;">Sub Total</td>
                            <td class="mono" style="font-weight: 700; font-size: 14px; color: var(--color-text); padding: 10px 16px;" id="subTotal">Rp 0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="11" style="text-align: right; font-size: 13px; color: var(--color-text-secondary); padding: 6px 16px;">DPP (11/12)</td>
                            <td class="mono" style="font-size: 13px; color: var(--color-text-secondary); padding: 6px 16px;" id="dppTotal">Rp 0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="11" style="text-align: right; font-size: 13px; color: var(--color-text-secondary); padding: 6px 16px;">PPN 12% dari DPP</td>
                            <td class="mono" style="font-size: 13px; color: var(--color-text-secondary); padding: 6px 16px;" id="ppnTotal">Rp 0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="11" style="text-align: right; font-weight: 700; font-size: 16px; color: var(--color-primary); padding: 12px 16px; border-top: 2px solid var(--color-border);">Total</td>
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

        // Parse existing surat_jalan data (comma-separated string to array)
        let sjList = [''];
        if (data.surat_jalan) {
            if (Array.isArray(data.surat_jalan)) {
                sjList = data.surat_jalan.length > 0 ? data.surat_jalan : [''];
            } else {
                sjList = data.surat_jalan.split(',').map(s => s.trim()).filter(s => s);
                if (sjList.length === 0) sjList = [''];
            }
        }

        const sjInputsHtml = sjList.map((sj, si) => `
            <div class="sj-entry" style="display: flex; gap: 3px; margin-bottom: 3px; align-items: center;">
                <input type="text" name="items[${itemIndex}][surat_jalan][]" class="form-input sj-input" value="${sj}" placeholder="No. SJ" style="${inputStyle} font-family: var(--font-mono); flex: 1; min-width: 0;">
                ${si === 0 ? `<button type="button" class="btn-icon sj-add-btn" onclick="addSuratJalan(${itemIndex})" style="color: var(--color-primary); width: 22px; height: 22px; flex-shrink: 0;" title="Tambah Srt Jalan">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </button>` : `<button type="button" class="btn-icon" onclick="removeSuratJalan(this)" style="color: var(--color-danger); width: 22px; height: 22px; flex-shrink: 0;" title="Hapus">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>`}
            </div>
        `).join('');

        row.innerHTML = `
            <td style="padding: 6px 4px;"><input type="date" name="items[${itemIndex}][tanggal_kirim]" class="form-input" value="${data.tanggal_kirim || ''}" required style="${inputStyle}"></td>
            <td style="padding: 6px 4px;">
                <div class="search-dropdown" style="position: relative;">
                    <input type="text" class="form-input nopol-search" data-idx="${itemIndex}" autocomplete="off" placeholder="Cari no polisi..." value="${data.no_pol || ''}" style="${inputStyle} text-transform: uppercase;" onfocus="showNopolDropdown(${itemIndex})" oninput="filterNopol(${itemIndex})">
                    <input type="hidden" name="items[${itemIndex}][no_pol]" class="nopol-value" value="${data.no_pol || ''}">
                    <div class="nopol-dropdown" id="nopol-dd-${itemIndex}" style="display:none; position:absolute; top:100%; left:0; width:220px; background:var(--color-surface); border:1px solid var(--color-border); border-radius:8px; box-shadow:0 8px 24px rgba(0,0,0,0.15); max-height:200px; overflow-y:auto; z-index:9999; margin-top:2px;"></div>
                </div>
            </td>
            <td style="padding: 6px 4px;">
                <div class="search-dropdown" style="position: relative;">
                    <input type="text" class="form-input penerima-search" data-idx="${itemIndex}" autocomplete="off" placeholder="Cari penerima..." value="${data.penerima || ''}" style="${inputStyle}" onfocus="showPenerimaDropdown(${itemIndex})" oninput="filterPenerima(${itemIndex})">
                    <input type="hidden" name="items[${itemIndex}][penerima]" class="penerima-value" value="${data.penerima || ''}">
                    <div class="penerima-dropdown" id="penerima-dd-${itemIndex}" style="display:none; position:absolute; top:100%; left:0; width:260px; background:var(--color-surface); border:1px solid var(--color-border); border-radius:8px; box-shadow:0 8px 24px rgba(0,0,0,0.15); max-height:200px; overflow-y:auto; z-index:9999; margin-top:2px;"></div>
                </div>
            </td>
            <td style="padding: 6px 4px;"><input type="text" name="items[${itemIndex}][sa_no]" class="form-input" value="${data.sa_no || ''}" placeholder="SA No" style="${inputStyle} font-family: var(--font-mono);"></td>
            <td style="padding: 6px 4px;">
                <div class="sj-container" id="sj-container-${itemIndex}">
                    ${sjInputsHtml}
                </div>
            </td>
            <td style="padding: 6px 4px;"><input type="text" name="items[${itemIndex}][tujuan]" class="form-input" value="${data.tujuan || ''}" placeholder="Kota" style="${inputStyle}"></td>
            <td style="padding: 6px 4px;"><input type="text" name="items[${itemIndex}][keterangan]" class="form-input" value="${data.keterangan || ''}" placeholder="KET" style="${inputStyle}"></td>
            <td style="padding: 6px 4px;"><input type="number" name="items[${itemIndex}][colly]" class="form-input" value="${data.colly || ''}" min="0" style="${inputStyle} text-align: center;"></td>
            <td style="padding: 6px 4px;"><input type="number" name="items[${itemIndex}][tonase]" class="form-input tonase-input" value="${data.tonase || ''}" step="0.01" min="0" required style="${inputStyle} font-family: var(--font-mono); text-align: right;"></td>
            <td style="padding: 6px 4px;">
                <select name="items[${itemIndex}][satuan]" class="form-input satuan-select" style="${inputStyle}">
                    <option value="Kg" ${(data.satuan || 'Kg') === 'Kg' ? 'selected' : ''}>Kg</option>
                    <option value="Ton" ${data.satuan === 'Ton' ? 'selected' : ''}>Ton</option>
                    <option value="Pcs" ${data.satuan === 'Pcs' ? 'selected' : ''}>Pcs</option>
                    <option value="Box" ${data.satuan === 'Box' ? 'selected' : ''}>Box</option>
                    <option value="Ltr" ${data.satuan === 'Ltr' ? 'selected' : ''}>Ltr</option>
                    <option value="M3" ${data.satuan === 'M3' ? 'selected' : ''}>M³</option>
                    <option value="Unit" ${data.satuan === 'Unit' ? 'selected' : ''}>Unit</option>
                    <option value="Set" ${data.satuan === 'Set' ? 'selected' : ''}>Set</option>
                </select>
            </td>
            <td style="padding: 6px 4px;"><input type="number" name="items[${itemIndex}][tarif]" class="form-input tarif-input" value="${data.tarif || ''}" step="0.01" min="0" style="${inputStyle} font-family: var(--font-mono); text-align: right;"></td>
            <td style="padding: 6px 4px;"><input type="number" name="items[${itemIndex}][jumlah]" class="form-input jumlah-input" value="${data.jumlah || ''}" step="0.01" min="0" required onchange="calcTotals()" oninput="calcTotals()" style="${inputStyle} font-family: var(--font-mono); text-align: right; font-weight: 600;"></td>
            <td style="padding: 6px 4px; text-align: center;">
                <button type="button" class="btn-icon" onclick="removeItem(${itemIndex})" style="color: var(--color-danger); width: 28px; height: 28px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </td>
        `;

        tbody.appendChild(row);
        if (data.jumlah) calcTotals();
        itemIndex++;
    }

    // Tambah input surat jalan baru
    function addSuratJalan(idx) {
        const container = document.getElementById(`sj-container-${idx}`);
        if (!container) return;
        const entry = document.createElement('div');
        entry.className = 'sj-entry';
        entry.style.cssText = 'display: flex; gap: 3px; margin-bottom: 3px; align-items: center;';
        entry.innerHTML = `
            <input type="text" name="items[${idx}][surat_jalan][]" class="form-input sj-input" value="" placeholder="No. SJ" style="${inputStyle} font-family: var(--font-mono); flex: 1; min-width: 0;">
            <button type="button" class="btn-icon" onclick="removeSuratJalan(this)" style="color: var(--color-danger); width: 22px; height: 22px; flex-shrink: 0;" title="Hapus">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        `;
        container.appendChild(entry);
    }

    // Hapus input surat jalan
    function removeSuratJalan(btn) {
        btn.closest('.sj-entry').remove();
    }

    function removeItem(idx) { const row = document.getElementById(`item-row-${idx}`); if (row) { row.remove(); calcTotals(); } }

    function calcTotals() {
        let sub = 0;
        document.querySelectorAll('#itemsBody tr').forEach(row => {
            const jumlah = parseFloat(row.querySelector('.jumlah-input')?.value) || 0;
            sub += jumlah;
        });
        const dpp = sub * 11 / 12;
        const ppn = dpp * 0.12;
        document.getElementById('subTotal').textContent = formatRp(sub);
        document.getElementById('dppTotal').textContent = formatRp(Math.round(dpp));
        document.getElementById('ppnTotal').textContent = formatRp(Math.round(ppn));
        document.getElementById('grandTotal').textContent = formatRp(Math.round(dpp + ppn));
    }

    function formatRp(n) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(n)); }

    // Close all dropdowns
    function closeAllDropdowns() {
        document.querySelectorAll('.nopol-dropdown, .penerima-dropdown').forEach(dd => dd.style.display = 'none');
    }

    function showNopolDropdown(idx) { closeAllDropdowns(); filterNopol(idx); }

    function filterNopol(idx) {
        const row = document.getElementById(`item-row-${idx}`);
        if (!row) return;
        const input = row.querySelector('.nopol-search');
        const search = input.value.toLowerCase();
        const dd = document.getElementById(`nopol-dd-${idx}`);
        const filtered = kendaraanList.filter(k =>
            k.no_pol.toLowerCase().includes(search) ||
            (k.jenis && k.jenis.toLowerCase().includes(search)) ||
            (k.driver && k.driver.toLowerCase().includes(search))
        );
        dd.innerHTML = filtered.length === 0
            ? '<div style="padding:10px 12px; font-size:12px; color:var(--color-text-muted);">Tidak ditemukan</div>'
            : filtered.map(k => `
                <div class="nopol-option" onclick="selectNopol(${idx}, '${k.no_pol}')" style="padding:8px 12px; cursor:pointer; font-size:12px; border-bottom:1px solid var(--color-border); transition: background 0.15s;">
                    <div style="font-weight:600; text-transform:uppercase; color:var(--color-text);">${k.no_pol}</div>
                    <div style="font-size:11px; color:var(--color-text-muted);">${k.jenis || ''} ${k.driver ? '• ' + k.driver : ''}</div>
                </div>
            `).join('');
        dd.style.display = 'block';
    }

    function selectNopol(idx, noPol) {
        const row = document.getElementById(`item-row-${idx}`);
        if (!row) return;
        row.querySelector('.nopol-search').value = noPol;
        row.querySelector('.nopol-value').value = noPol;
        document.getElementById(`nopol-dd-${idx}`).style.display = 'none';
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-dropdown')) {
            document.querySelectorAll('.nopol-dropdown, .penerima-dropdown').forEach(dd => dd.style.display = 'none');
        }
    });
    document.addEventListener('mouseover', function(e) {
        const opt = e.target.closest('.nopol-option, .penerima-option');
        if (opt) opt.style.background = 'var(--color-bg)';
    });
    document.addEventListener('mouseout', function(e) {
        const opt = e.target.closest('.nopol-option, .penerima-option');
        if (opt) opt.style.background = 'transparent';
    });

    // Kendaraan data for searchable dropdown
    const kendaraanList = @json($kendaraans->map(fn($k) => ['no_pol' => $k->no_pol, 'jenis' => $k->jenis_kendaraan, 'driver' => $k->nama_driver]));

    // Penerima data for searchable dropdown
    const penerimaList = @json($pelanggans->map(fn($p) => ['nama' => $p->nama_pelanggan, 'alamat' => $p->alamat]));

    function showPenerimaDropdown(idx) { closeAllDropdowns(); filterPenerima(idx); }

    function filterPenerima(idx) {
        const row = document.getElementById(`item-row-${idx}`);
        if (!row) return;
        const input = row.querySelector('.penerima-search');
        const search = input.value.toLowerCase();
        const dd = document.getElementById(`penerima-dd-${idx}`);
        const filtered = penerimaList.filter(p =>
            p.nama.toLowerCase().includes(search) ||
            (p.alamat && p.alamat.toLowerCase().includes(search))
        );
        dd.innerHTML = filtered.length === 0
            ? '<div style="padding:10px 12px; font-size:12px; color:var(--color-text-muted);">Tidak ditemukan</div>'
            : filtered.map(p => `
                <div class="penerima-option" onclick="selectPenerima(${idx}, '${p.nama.replace(/'/g, "\\'")}')"
                     style="padding:8px 12px; cursor:pointer; font-size:12px; border-bottom:1px solid var(--color-border); transition: background 0.15s;">
                    <div style="font-weight:600; color:var(--color-text);">${p.nama}</div>
                    ${p.alamat ? `<div style="font-size:11px; color:var(--color-text-muted); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${p.alamat}</div>` : ''}
                </div>
            `).join('');
        dd.style.display = 'block';
    }

    function selectPenerima(idx, nama) {
        const row = document.getElementById(`item-row-${idx}`);
        if (!row) return;
        row.querySelector('.penerima-search').value = nama;
        row.querySelector('.penerima-value').value = nama;
        document.getElementById(`penerima-dd-${idx}`).style.display = 'none';
    }


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
            jumlah: {{ $detail->jumlah ?? 0 }},
        });
    @endforeach
</script>
@endpush
