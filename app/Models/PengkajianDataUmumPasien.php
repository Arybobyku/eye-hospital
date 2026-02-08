<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PengkajianDataUmumPasien extends Model
{
    use HasFactory, Notifiable;
    
    protected $table = 'pengkajian_data_umum_pasien';
    public $timestamps = false;
    
    protected $fillable = [
        "uuid_pasien",
        "tanggal",
        "waktu",
        "nik",
        "kodemr",
        "nama",
        "nama_pasangan",
        "nik_pasangan",
        "pekerjaan",
        "alamat",
        "agama",
        "jenis_kelamin",
        "tempat_tanggal_lahir",
        "status_pembiayaan",
        "status_perkawinan",
        "pendidikan",
    ];

    public static function store($request)
    {
        return self::create([
            "uuid_pasien" => $request->uuid_pasien,
            "tanggal" => $request->tanggal,
            "waktu" => $request->waktu,
            "nik" => $request->nik,
            "kodemr" => $request->kodemr,
            "nama" => $request->nama,
            "nama_pasangan" => $request->namaPasangan,
            "nik_pasangan" => $request->nikPasangan,
            "pekerjaan" => $request->pekerjaan,
            "alamat" => $request->alamat,
            "agama" => $request->agama,
            "jenis_kelamin" => $request->jenisKelamin,
            "tempat_tanggal_lahir" => $request->tempatTanggalLahir,
            "status_pembiayaan" => $request->statusPembiayaan,
            "status_perkawinan" => $request->statusPerkawinan,
            "pendidikan" => $request->pendidikan,
        ]);
    }
}