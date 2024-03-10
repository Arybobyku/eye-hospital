<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RunningImage extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'running_image';
  public $timestamps = false;
}
