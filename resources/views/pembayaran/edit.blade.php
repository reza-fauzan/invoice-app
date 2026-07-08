@extends('layouts.app')

@section('title', 'Edit Pembayaran')

@section('page-actions')
    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary btn-sm">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')

    {{-- Form --}}
    <div class="card">
        <form action="{{ route('pembayaran.update', $pembayaran) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: flex; flex-direction: column; gap: 20px;">
                {{-- Invoice --}}
                <div>
                    <label for="invoice_id" class="form-label">Invoice <span style="color: var(--color-danger);">*</span></label>
                    <select name="invoice_id" id="invoice_id" class="form-input" required>
                        <option value="">— Pilih Invoice —</option>
                        @foreach($invoices as $invoice)
                            <option value="{{ $invoice->id }}" {{ old('invoice_id', $pembayaran->invoice_id) == $invoice->id ? 'selected' : '' }}>
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
                        <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-input" value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar->format('Y-m-d')) }}" required>
                        @error('tanggal_bayar')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jumlah Bayar --}}
                    <div>
                        <label for="jumlah_bayar" class="form-label">Jumlah Bayar (Rp) <span style="color: var(--color-danger);">*</span></label>
                        <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-input" placeholder="0" value="{{ old('jumlah_bayar', $pembayaran->jumlah_bayar) }}" min="1" step="0.01" required style="font-family: var(--font-mono);">
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
                            @foreach(['Transfer Bank', 'Cash', 'E-Wallet', 'QRIS'] as $metode)
                                <option value="{{ $metode }}" {{ old('metode_pembayaran', $pembayaran->metode_pembayaran) == $metode ? 'selected' : '' }}>{{ $metode }}</option>
                            @endforeach
                        </select>
                        @error('metode_pembayaran')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Validasi --}}
                    <div>
                        <label for="status_validasi" class="form-label">Status Validasi <span style="color: var(--color-danger);">*</span></label>
                        <select name="status_validasi" id="status_validasi" class="form-input" required>
                            @foreach(['Pending', 'Verified', 'Rejected'] as $status)
                                <option value="{{ $status }}" {{ old('status_validasi', $pembayaran->status_validasi) == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status_validasi')
                            <p style="color: var(--color-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Bukti Bayar --}}
                <div>
                    <label for="bukti_bayar" class="form-label">Bukti Bayar <span style="color: var(--color-text-muted); font-weight: 400;">(opsional)</span></label>
                    @if($pembayaran->bukti_bayar)
                        <p style="font-size: 13px; color: var(--color-text-secondary); margin-bottom: 6px;">
                            File saat ini: <strong>{{ basename($pembayaran->bukti_bayar) }}</strong>
                        </p>
                    @endif
                    <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-input" accept=".jpg,.jpeg,.png,.pdf" style="padding: 8px 10px;">
                    <p style="color: var(--color-text-muted); font-size: 12px; margin-top: 4px;">Kosongkan jika tidak ingin mengubah file. Format: JPG, PNG, PDF. Maks: 2MB</p>
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
                        Update
                    </button>
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
