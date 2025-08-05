<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanggapanBukti extends Model
{
    protected $fillable = [
        'tanggapan_id',
        'bukti',
    ];
}
