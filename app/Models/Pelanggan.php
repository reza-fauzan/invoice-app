<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Invoice;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';

    protected $fillable = [
        'nama_pelanggan',
        'alamat',
        'telepon',
        'email',
        'npwp',
    ];

    /**
     * Format nomor telepon untuk WhatsApp (mengubah awal 0 menjadi 62).
     */
    public function getWhatsappNumberAttribute()
    {
        $phone = preg_replace('/[^0-9]/', '', $this->telepon);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        return $phone;
    }

    /**
     * Pelanggan memiliki banyak Invoice.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
