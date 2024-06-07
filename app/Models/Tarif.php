<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tarif extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'tarif';
  public $timestamps = false;
}
