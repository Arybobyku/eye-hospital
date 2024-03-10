<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Label extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'label';
  public $timestamps = false;
}
