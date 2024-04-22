<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JenisKamar extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'jenis_kamar';
  public $timestamps = false;
}
