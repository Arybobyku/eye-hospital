<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ListPaketBedahBaru extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'list_paket_bedah_baru';
  public $timestamps = false;
}
