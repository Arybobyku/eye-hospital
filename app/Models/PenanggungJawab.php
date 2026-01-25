<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PenanggungJawab extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'penanggung_jawab';
  public $timestamps = false;
}
