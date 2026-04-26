<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RincianTagihan extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'rincian_tagihan';
  public $timestamps = false;
}
