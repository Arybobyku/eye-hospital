<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PasienTransfer extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'pasien_transfer';
  public $timestamps = false;
}
