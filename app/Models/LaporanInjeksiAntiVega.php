<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LaporanInjeksiAntiVega extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'laporan_injeksi_av';
  public $timestamps = false;
}