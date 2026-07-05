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
    ];

    /**
     * Pelanggan memiliki banyak Invoice.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
