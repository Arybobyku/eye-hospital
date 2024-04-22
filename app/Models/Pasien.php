<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pasien extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'pasien';
  public $timestamps = false;

	public function registrasi()
  {
   return $this->hasOne(Registrasi::class, 'pasien_uuid', 'uuid')->select('id', 'pasien_uuid', 'tanggal');
	}
}
