<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AntrolLogs extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'antrol_logs';
  public $timestamps = false;
}
