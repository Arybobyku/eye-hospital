<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CaraBayarKamar extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'carabayar_kamar';
  public $timestamps = false;
}
