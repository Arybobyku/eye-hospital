<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AntrianRo extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'antrian_ro';
  public $timestamps = false;
}
