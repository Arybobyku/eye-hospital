<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AntrianFarmasi extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'antrian_farmasi';
  public $timestamps = false;
}
