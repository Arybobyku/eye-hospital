<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AntrianPoli extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'antrian_poli';
  public $timestamps = false;
}
