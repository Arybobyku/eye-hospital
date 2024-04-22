<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Antrian extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'antrian';
  public $timestamps = false;
}
