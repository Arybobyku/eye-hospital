<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class KwitansiKeuangan extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'kwitansi_keuangan';
  public $timestamps = false;
}
