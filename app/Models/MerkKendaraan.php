<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerkKendaraan extends Model
{
    protected $table = 'merk_kendaraans';

    protected $fillable = ['nama'];
}
