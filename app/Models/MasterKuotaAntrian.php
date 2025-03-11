<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MasterKuotaAntrian extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'master_kuota_antrian';
  public $timestamps = false;
}
