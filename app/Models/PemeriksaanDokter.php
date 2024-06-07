<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PemeriksaanDokter extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'pemeriksaan_dokter';
  public $timestamps = false;
}
