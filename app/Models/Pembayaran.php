<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $fillable = [
        'invoice_id',
        'tanggal_bayar',
        'jumlah_bayar',
        'metode_pembayaran',
        'bukti_bayar',
        'status_validasi',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($pembayaran) {
            if ($pembayaran->invoice) {
                $pembayaran->invoice->updateStatusPembayaran();
            }
        });

        static::updated(function ($pembayaran) {
            if ($pembayaran->isDirty('invoice_id')) {
                $oldInvoiceId = $pembayaran->getOriginal('invoice_id');
                if ($oldInvoiceId) {
                    $oldInvoice = Invoice::find($oldInvoiceId);
                    if ($oldInvoice) {
                        $oldInvoice->updateStatusPembayaran();
                    }
                }
            }
            if ($pembayaran->invoice) {
                $pembayaran->invoice->updateStatusPembayaran();
            }
        });

        static::deleted(function ($pembayaran) {
            if ($pembayaran->invoice) {
                $pembayaran->invoice->updateStatusPembayaran();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'tanggal_bayar' => 'date',
            'jumlah_bayar' => 'decimal:2',
        ];
    }

    /**
     * Pembayaran milik satu Invoice.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
