<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $fillable = [
        'nik',
        'no_kk',
        'user_id',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'gol_darah',
        'no_rumah',
        'rt',
        'rw',
        'no_hp',
        'agama_id',
        'status_perkawinan_id',
        'pekerjaan_id',
        'status_warga',
        'email',
    ];
}
