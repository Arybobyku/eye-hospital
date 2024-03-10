<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Provinsi extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'provinsi';
  public $timestamps = false;
}
