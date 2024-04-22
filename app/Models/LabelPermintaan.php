<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LabelPermintaan extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'label_permintaan';
  public $timestamps = false;
}
