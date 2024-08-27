<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;
    protected $table = 'pendaftaran';
    public $timestamps = false;
    protected $fillable = [
        'norm',  
        'no_pendaftaran',
        'tgl_kunjungan',
        'tgl_selesai_kunjungan',
        'poliklinik_id',
        'dokter_id',
        'penjamin_id',
        'status',
    ];
}
