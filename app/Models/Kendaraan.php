<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraans';

    protected $fillable = [
        'no_pol',
        'jenis_kendaraan',
        'merk',
        'tahun',
        'nama_driver',
        'no_telp_driver',
        'status',
        'keterangan',
    ];
}
