<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MasterPoliBpjs extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'master_poli_bpjs';
  public $timestamps = false;

  protected $fillable = [
    'kdsubspesialis', // Add this field
    'nmpoli',
    'nmsubspesialis',
    'kdpoli'
];
}
