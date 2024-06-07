<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class KlaimRawatJalan extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'klaim_rawat_jalan';
  public $timestamps = false;
}
