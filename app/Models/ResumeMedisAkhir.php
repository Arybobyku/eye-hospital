<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ResumeMedisAkhir extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'resume_medis_akhir';
  public $timestamps = false;
}
