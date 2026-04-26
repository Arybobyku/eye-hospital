<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class StockOpnameHistori extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'stock_opname_histori';
  public $timestamps = false;
}
