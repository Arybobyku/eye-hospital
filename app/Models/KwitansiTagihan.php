<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class KwitansiTagihan extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'kwitansi_tagihan';
  public $timestamps = false;
}
