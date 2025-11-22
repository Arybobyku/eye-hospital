<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Cppt extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'cppt';
  public $timestamps = false;

  public function pengguna()
  {
    return $this->belongsTo(Pengguna::class, 'pengguna_uuid', 'uuid');
  }

  public function registrasi()
{
    return $this->belongsTo(Registrasi::class, 'registrasi_uuid', 'uuid');
}

  public function pemeriksaanDokter()
{
    return $this->belongsTo(PemeriksaanDokter::class, 'registrasi_uuid', 'registrasi_uuid');
}
}
