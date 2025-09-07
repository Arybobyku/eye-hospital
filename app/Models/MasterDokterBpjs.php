<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MasterDokterBpjs extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'master_dokter_bpjs';
  public $timestamps = false;

  protected $fillable = [
    'nik', // Add this field
    'namadokter',
    'kodedokter',
];
}
