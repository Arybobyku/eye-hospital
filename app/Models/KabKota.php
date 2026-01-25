<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Kabkota extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'kab_kota';
  public $timestamps = false;
}
