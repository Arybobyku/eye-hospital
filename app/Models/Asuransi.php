<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Asuransi extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'asuransi';
  public $timestamps = false;
}
