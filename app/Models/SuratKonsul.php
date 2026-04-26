<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SuratKonsul extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'suratkonsul';
  public $timestamps = false;
}
