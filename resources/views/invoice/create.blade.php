@extends('layouts.app')

@section('title', 'Buat Invoice')

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Buat Invoice</h1>
            <p>Buat invoice baru untuk pelanggan.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('invoice.index') }}" class="btn btn-secondary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('invoice.store') }}" method="POST" id="invoiceForm">
        @csrf

        {{-- Invoice Info --}}
        <div class="card" style="margin-bottom: 20px;">
            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: var(--color-text);">Informasi Invoice</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                {{-- Pelanggan --}}
                <div>
                    <label for="pelanggan_id" class="form-label">Pelanggan <span style="color: var(--color-danger);">*</span></label>
                    <select name="pelanggan_id" id="pelanggan_id" class="form-input" required>
                        <option value="">— Pilih Pelanggan —</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                                {{ $pelanggan->nama_pelanggan }}
                            </option>
                        @endforeach
                    </select>
                    @error('pelanggan_id')
                        <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="tanggal_invoice" class="form-label">Tanggal Invoice <span style="color: var(--color-danger);">*</span></label>
                    <input type="date" name="tanggal_invoice" id="tanggal_invoice" class="form-input" value="{{ old('tanggal_invoice', date('Y-m-d')) }}" required>
                    @error('tanggal_invoice')
                        <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status_pembayaran" class="form-label">Status <span style="color: var(--color-danger);">*</span></label>
                    <select name="status_pembayaran" id="status_pembayaran" class="form-input" required>
                        <option value="Draft" {{ old('status_pembayaran') == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Unpaid" {{ old('status_pembayaran', 'Unpaid') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="Paid" {{ old('status_pembayaran') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                    @error('status_pembayaran')
                        <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Invoice Items --}}
        <div class="card" style="margin-bottom: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <h3 style="font-size: 16px; font-weight: 700; color: var(--color-text);">Item Produk</h3>
                <button type="button" class="btn btn-primary btn-sm" onclick="addItem()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Item
                </button>
            </div>

            @error('items')
                <div class="alert alert-danger" style="margin-bottom: 16px;">{{ $message }}</div>
            @enderror

            <table id="itemsTable">
                <thead>
                    <tr>
                        <th style="width: 40%;">Produk</th>
                        <th style="width: 12%;">Qty</th>
                        <th style="width: 20%;">Harga Satuan</th>
                        <th style="width: 20%;">Subtotal</th>
                        <th style="width: 8%;"></th>
                    </tr>
                </thead>
                <tbody id="itemsBody">
                    {{-- Row template via JS --}}
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: 700; font-size: 15px; color: var(--color-text); padding: 16px 24px;">
                            Total Tagihan
                        </td>
                        <td style="font-family: var(--font-mono); font-weight: 700; font-size: 18px; color: var(--color-primary); padding: 16px 24px;" id="grandTotal">
                            Rp 0
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Submit --}}
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan Invoice
            </button>
            <a href="{{ route('invoice.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    const produks = @json($produks);
    let itemIndex = 0;

    function addItem(produkId = '', qty = 1) {
        const tbody = document.getElementById('itemsBody');
        const row = document.createElement('tr');
        row.id = `item-row-${itemIndex}`;

        let produkOptions = '<option value="">— Pilih Produk —</option>';
        produks.forEach(p => {
            const selected = p.id == produkId ? 'selected' : '';
            produkOptions += `<option value="${p.id}" data-harga="${p.harga}" ${selected}>${p.nama_produk}</option>`;
        });

        row.innerHTML = `
            <td style="padding: 12px 24px;">
                <select name="items[${itemIndex}][produk_id]" class="form-input produk-select" data-index="${itemIndex}" onchange="updateRow(${itemIndex})" required style="font-size: 13px; padding: 8px 10px;">
                    ${produkOptions}
                </select>
            </td>
            <td style="padding: 12px 8px;">
                <input type="number" name="items[${itemIndex}][qty]" class="form-input qty-input" value="${qty}" min="1" onchange="updateRow(${itemIndex})" oninput="updateRow(${itemIndex})" required style="font-size: 13px; padding: 8px 10px; text-align: center; font-family: var(--font-mono);">
            </td>
            <td style="padding: 12px 8px;">
                <span class="mono harga-satuan" id="harga-${itemIndex}" style="font-size: 13px; color: var(--color-text-secondary);">Rp 0</span>
            </td>
            <td style="padding: 12px 8px;">
                <span class="mono subtotal" id="subtotal-${itemIndex}" style="font-size: 13px; font-weight: 600; color: var(--color-text);">Rp 0</span>
            </td>
            <td style="padding: 12px 8px; text-align: center;">
                <button type="button" class="btn-icon" onclick="removeItem(${itemIndex})" title="Hapus" style="color: var(--color-danger); width: 30px; height: 30px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </td>
        `;

        tbody.appendChild(row);
        if (produkId) updateRow(itemIndex);
        itemIndex++;
    }

    function updateRow(index) {
        const row = document.getElementById(`item-row-${index}`);
        if (!row) return;

        const select = row.querySelector('.produk-select');
        const qtyInput = row.querySelector('.qty-input');
        const selectedOption = select.options[select.selectedIndex];
        const harga = parseFloat(selectedOption.dataset.harga) || 0;
        const qty = parseInt(qtyInput.value) || 0;
        const subtotal = harga * qty;

        document.getElementById(`harga-${index}`).textContent = formatRupiah(harga);
        document.getElementById(`subtotal-${index}`).textContent = formatRupiah(subtotal);

        calculateTotal();
    }

    function removeItem(index) {
        const row = document.getElementById(`item-row-${index}`);
        if (row) {
            row.remove();
            calculateTotal();
        }
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('#itemsBody tr').forEach(row => {
            const select = row.querySelector('.produk-select');
            const qtyInput = row.querySelector('.qty-input');
            if (select && qtyInput) {
                const harga = parseFloat(select.options[select.selectedIndex]?.dataset?.harga) || 0;
                const qty = parseInt(qtyInput.value) || 0;
                total += harga * qty;
            }
        });
        document.getElementById('grandTotal').textContent = formatRupiah(total);
    }

    function formatRupiah(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    // Add first row by default
    addItem();
</script>
@endpush
