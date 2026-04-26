<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ResepBebas extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'resepbebas';
  public $timestamps = false;
}
