@extends('layouts.app')

@section('title', 'Catat Pembayaran')

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Catat Pembayaran</h1>
            <p>Catat pembayaran baru untuk sebuah invoice.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Form --}}
    <div class="card" style="max-width: 640px;">
        <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: flex; flex-direction: column; gap: 20px;">
                {{-- Invoice --}}
                <div>
                    <label for="invoice_id" class="form-label">Invoice <span style="color: var(--color-danger);">*</span></label>
                    <select name="invoice_id" id="invoice_id" class="form-input" required>
                        <option value="">— Pilih Invoice —</option>
                        @foreach($invoices as $invoice)
                            <option value="{{ $invoice->id }}" {{ old('invoice_id', $selectedInvoice) == $invoice->id ? 'selected' : '' }}>
                                {{ $invoice->nomor_invoice }} — {{ $invoice->pelanggan->nama_pelanggan }} (Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    @error('invoice_id')
                        <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    {{-- Tanggal Bayar --}}
                    <div>
                        <label for="tanggal_bayar" class="form-label">Tanggal Bayar <span style="color: var(--color-danger);">*</span></label>
                        <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-input" value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required>
                        @error('tanggal_bayar')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jumlah Bayar --}}
                    <div>
                        <label for="jumlah_bayar" class="form-label">Jumlah Bayar (Rp) <span style="color: var(--color-danger);">*</span></label>
                        <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-input" placeholder="0" value="{{ old('jumlah_bayar') }}" min="1" step="0.01" required style="font-family: var(--font-mono);">
                        @error('jumlah_bayar')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    {{-- Metode Pembayaran --}}
                    <div>
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran <span style="color: var(--color-danger);">*</span></label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-input" required>
                            <option value="">— Pilih Metode —</option>
                            <option value="Transfer Bank" {{ old('metode_pembayaran') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="Cash" {{ old('metode_pembayaran') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="E-Wallet" {{ old('metode_pembayaran') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                            <option value="QRIS" {{ old('metode_pembayaran') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                        </select>
                        @error('metode_pembayaran')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Validasi --}}
                    <div>
                        <label for="status_validasi" class="form-label">Status Validasi <span style="color: var(--color-danger);">*</span></label>
                        <select name="status_validasi" id="status_validasi" class="form-input" required>
                            <option value="Pending" {{ old('status_validasi', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Verified" {{ old('status_validasi') == 'Verified' ? 'selected' : '' }}>Verified</option>
                            <option value="Rejected" {{ old('status_validasi') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status_validasi')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Bukti Bayar --}}
                <div>
                    <label for="bukti_bayar" class="form-label">Bukti Bayar <span style="color: var(--color-text-muted); font-weight: 400;">(opsional)</span></label>
                    <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-input" accept=".jpg,.jpeg,.png,.pdf" style="padding: 8px 10px;">
                    <p style="color: var(--color-text-muted); font-size: 12px; margin-top: 4px;">Format: JPG, PNG, PDF. Maks: 2MB</p>
                    @error('bukti_bayar')
                        <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div style="display: flex; gap: 10px; padding-top: 8px;">
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan
                    </button>
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
