<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EdukasiPasien extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'edukasi_pasien';
  public $timestamps = false;
}
