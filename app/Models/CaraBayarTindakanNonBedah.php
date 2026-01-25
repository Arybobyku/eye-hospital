<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CaraBayarTindakanNonBedah extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'carabayar_tindakan_non_bedah';
  public $timestamps = false;
}
