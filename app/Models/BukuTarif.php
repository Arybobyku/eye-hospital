<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class BukuTarif extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'buku_tarif';
  public $timestamps = false;
}
