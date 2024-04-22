<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'pengguna';
  public $timestamps = false;
}
