<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LabelStockOpname extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'label_stockopname';
  public $timestamps = false;
}
