<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPengaduan extends Model
{
    protected $fillable = [
        'nama',
        'keterangan',
        'isActive',
    ];
}
