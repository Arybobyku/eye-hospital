<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HakAkses extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'hak_akses';
  public $timestamps = false;
}
