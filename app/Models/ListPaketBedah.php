<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ListPaketBedah extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'list_paket_bedah';
  public $timestamps = false;
}
