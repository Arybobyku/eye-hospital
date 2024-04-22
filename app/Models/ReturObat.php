<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ReturObat extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'retur_obat';
  public $timestamps = false;
}
