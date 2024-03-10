<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SuratKontrol extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'surat_kontrol';
  public $timestamps = false;
}
