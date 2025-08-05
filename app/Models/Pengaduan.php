<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'jenis_pengaduan_id',
        'warga_id',
        'judul',
        'isi',
        'status',
    ];

    public function jenis_pengaduan()
    {
        return $this->belongsTo(JenisPengaduan::class);
    }
    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function tanggapan()
    {
        return $this->hasOne(Tanggapan::class,'pengaduan_id');
    }
}
