<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FormTindakanOperasi extends Model
{
  use HasFactory, Notifiable;
  protected $table = 'list_form_tindakan_operasi';
  public $timestamps = false;
}