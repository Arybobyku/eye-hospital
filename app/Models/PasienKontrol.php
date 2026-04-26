<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PasienKontrol extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'pasien_kontrol';
  public $timestamps = false;
}
