<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class KeselamatanBedah extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'keselamatan_bedah';
  public $timestamps = false;
}
