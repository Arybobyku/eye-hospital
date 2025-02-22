<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AntrianFarmasiBebas extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'antrian_farmasi_bebas';
  public $timestamps = true;
}
