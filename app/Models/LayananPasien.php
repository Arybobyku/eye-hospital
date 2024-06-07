<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LayananPasien extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'layanan_pasien';
  public $timestamps = false;
}
