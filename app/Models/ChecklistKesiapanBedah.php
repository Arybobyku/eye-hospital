<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ChecklistKesiapanBedah extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'checklist_kesiapan_bedah';
  public $timestamps = false;
}
