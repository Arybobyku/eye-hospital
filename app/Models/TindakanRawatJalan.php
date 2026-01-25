<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TindakanRawatJalan extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'tindakan_rawat_jalan';
  public $timestamps = false;
}
