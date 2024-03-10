<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PerawatanPeriOperative extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'perawatan_peri_operative';
  public $timestamps = false;
}
