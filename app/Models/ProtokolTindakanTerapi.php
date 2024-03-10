<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProtokolTindakanTerapi extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'protokol_tindakan_terapi';
  public $timestamps = false;
}
