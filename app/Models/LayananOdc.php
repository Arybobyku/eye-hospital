<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LayananOdc extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'layanan_odc';
  public $timestamps = false;
}
