<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerima extends Model
{
    protected $table = 'penerimas';

    protected $fillable = ['nama', 'alamat', 'telepon'];
}
