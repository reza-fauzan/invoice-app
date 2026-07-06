<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceDetail extends Model
{
    protected $table = 'invoice_details';

    protected $fillable = [
        'invoice_id',
        'tanggal_kirim',
        'no_pol',
        'penerima',
        'sa_no',
        'surat_jalan',
        'tujuan',
        'keterangan',
        'colly',
        'tonase',
        'satuan',
        'tarif',
        'jumlah',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kirim' => 'date',
            'colly' => 'integer',
            'tonase' => 'decimal:2',
            'tarif' => 'decimal:2',
            'jumlah' => 'decimal:2',
        ];
    }

    /**
     * InvoiceDetail milik satu Invoice.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
