<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class KembaliAmbilObat extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'kembali_ambil_obat';
  public $timestamps = false;
}
