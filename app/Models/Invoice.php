<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Pelanggan;
use App\Models\InvoiceDetail;
use App\Models\Pembayaran;

class Invoice extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'nomor_invoice',
        'tanggal_invoice',
        'status_pembayaran',
        'total_tagihan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_invoice' => 'date',
            'total_tagihan' => 'decimal:2',
        ];
    }

    /**
     * Invoice milik satu Pelanggan.
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    /**
     * Invoice memiliki banyak InvoiceDetail.
     */
    public function invoiceDetails(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    /**
     * Invoice memiliki banyak Pembayaran.
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }
}
