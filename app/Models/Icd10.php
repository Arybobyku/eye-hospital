<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Icd10 extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'icd_ten';
  public $timestamps = false;
}
