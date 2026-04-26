<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DisplayAntrian extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'display_antrian';
  public $timestamps = false;
}
