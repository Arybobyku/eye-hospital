<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RunningText extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'running_text';
  public $timestamps = false;
}
