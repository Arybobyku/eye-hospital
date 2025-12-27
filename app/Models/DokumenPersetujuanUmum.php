<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DokumenPersetujuanUmum extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'dokumen_persetujuan_umum';
    protected $fillable = [
        "uuid_pasien",
        "no_rm",
        "nik",
        "nama_pasien",
        "nama_pemberi_informasi",
        "nama_penerima_informasi",
        "tanggal_lahir",
        "jenis_kelamin",
        "resume_rows",
        "catatan",
        "pasien_ttd",
        "nama_terang_pasien",
        "nama_terang_pemberi_inf",
        "pemberi_inf_ttd",
        "pasien_ttd",
        "created_at",
        "created_by",
        "updated_by",
        "updated_at",
    ];
    

}
