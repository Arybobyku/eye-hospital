<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LampiranRekamMedis extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'lampiran_rekammedis';
  public $timestamps = false;
}
