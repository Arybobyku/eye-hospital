<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RuangPoli extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'ruang_poli';
  public $timestamps = false;
}
