<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Registrasi extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'registrasi';
  public $timestamps = false;

	public function layanan()
  {
   return $this->hasMany(LayananPasien::class, 'registrasi_uuid', 'uuid')->select('registrasi_uuid', 'total');
	}
}
