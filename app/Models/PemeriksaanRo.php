<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PemeriksaanRo extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'pemeriksaan_ro';
  public $timestamps = false;
}
