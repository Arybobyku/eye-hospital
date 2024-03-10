<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class StockPermintaan extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'stock_permintaan';
  public $timestamps = false;
}
