<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MintaTerimaOpname extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'minta_terima_opname';
  public $timestamps = false;
}
