<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PemeriksaanDokterIcd9 extends Model
{
    use HasFactory;
    use Notifiable;
    protected $table = 'pemeriksaan_dokter_icdnine';
    public $timestamps = false;
}
