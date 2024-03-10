<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HasilKadarGulaDarah extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'hasil_kadar_gula_darah';
  public $timestamps = false;
}
