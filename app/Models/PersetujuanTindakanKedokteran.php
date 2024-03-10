<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PersetujuanTindakanKedokteran extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'persetujuan_tindakan_kedokteran';
  public $timestamps = false;
}
