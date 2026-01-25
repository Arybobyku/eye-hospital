<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PemeriksaanDokterIcd10 extends Model
{
    use HasFactory;
    use Notifiable;
    protected $table = 'pemeriksaan_dokter_icdten';
    public $timestamps = false;
}
