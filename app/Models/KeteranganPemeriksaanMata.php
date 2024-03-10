<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class KeteranganPemeriksaanMata extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'keterangan_pemeriksaan_mata';
  public $timestamps = false;
}
