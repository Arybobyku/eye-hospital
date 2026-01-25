<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PemeriksaanRo extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'pemeriksaan_ro';
  public $timestamps = false;
  
    public function pemeriksaanDokter()
    {
        return $this->hasOne(PemeriksaanDokter::class, 'registrasi_uuid', 'registrasi_uuid');
    }
    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'registrasi_uuid', 'uuid');
    }


    public function pemeriksaanDokterIcdnine()
    {
        return $this->hasMany(PemeriksaanDokterIcd9::class, 'registrasi_uuid', 'registrasi_uuid');
    }
    public function pemeriksaanDokterIcdten()
    {
        return $this->hasMany(PemeriksaanDokterIcd10::class, 'registrasi_uuid', 'registrasi_uuid');
    }
    public function resep()
    {
        return $this->hasMany(Resep::class, 'registrasi_uuid', 'registrasi_uuid');
    }
    
}

