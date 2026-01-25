<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Supplier extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'supplier';
  public $timestamps = false;
}
