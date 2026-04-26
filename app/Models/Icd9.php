<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Icd9 extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'icd_nine';
  public $timestamps = false;
}
