<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UploadSuratPersetujuan extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'upload_surat_persetujuan';
  public $timestamps = false;
}
