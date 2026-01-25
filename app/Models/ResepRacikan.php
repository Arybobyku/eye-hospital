<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ResepRacikan extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'resepracikan';
  public $timestamps = false;
}
