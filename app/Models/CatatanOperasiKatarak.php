<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CatatanOperasiKatarak extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'catatan_operasi_katarak';
  public $timestamps = false;
}
