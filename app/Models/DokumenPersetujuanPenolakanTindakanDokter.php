<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DokumenPersetujuanPenolakanTindakanDokter extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'dokumen_persetujuan_penolakan_tindakan_dokter';
    public $timestamps = false;
    protected $fillable = [
        "id",
        "uuid_pasien",
        "date",
        "time",
        "kodeMR",
        "nama",
        "usia",
        "lainlain",
        "lainlain_ttd",
        "alamat",
        "petugas",
        "pemberi_info",
        "penerima_info",
        "diagnosis",
        "diagnosis_ttd",
        "dasar_diagnosis",
        "dasar_diagnosis_ttd",
        "tindakan_kedokteran",
        "tindakan_kedokteran_ttd",
        "indikasi_tindakan",
        "indikasi_tindakan_ttd",
        "tata_cara",
        "tata_cara_ttd",
        "tujuan",
        "tujuan_ttd",
        "risiko",
        "risiko_ttd",
        "komplikasi",
        "komplikasi_ttd",
        "prognosis",
        "prognosis_ttd",
        "alternatif_dan_risiko",
        "alternatif_dan_risiko_ttd",
        "menyatakan_menerangkan_ttd",
        "menyatakan_memahami_ttd",
        "yang_bertanda_tangan",
        "berumur",
        "jenis_kelamin",
        "menyatakan",
        "dilakukan_tindakan",
        "yang_menyatakan",
        "yang_menyatakan_ttd",
        "saksi_1",
        "saksi_1_ttd",
        "saksi_2",
        "saksi_2_ttd",
    ];

    public static function store($request)
    {
        return self::create([
            "uuid_pasien" => $request->uuid_pasien,
            "date" => $request->date,
            "time" => $request->time,
            "kodemr" => $request->kodemr,
            "nama" => $request->nama,
            "usia" => $request->usia,
            "alamat" => $request->alamat,
            "petugas" => $request->petugas,
            "pemberi_info" => $request->pemberi_info,
            "penerima_info" => $request->penerima_info,

            "diagnosis" => $request->diagnosis,
            "diagnosis_ttd" => $request->diagnosis_ttd,

            "dasar_diagnosis" => $request->dasar_diagnosis,
            "dasar_diagnosis_ttd" => $request->dasar_diagnosis_ttd,

            "tindakan_kedokteran" => $request->tindakan_kedokteran,
            "tindakan_kedokteran_ttd" => $request->tindakan_kedokteran_ttd,

            "indikasi_tindakan" => $request->indikasi_tindakan,
            "indikasi_tindakan_ttd" => $request->indikasi_tindakan_ttd,

            "tata_cara" => $request->tata_cara,
            "tata_cara_ttd" => $request->tata_cara_ttd,

            "tujuan" => $request->tujuan,
            "tujuan_ttd" => $request->tujuan_ttd,

            "risiko" => $request->risiko,
            "risiko_ttd" => $request->risiko_ttd,

            "komplikasi" => $request->komplikasi,
            "komplikasi_ttd" => $request->komplikasi_ttd,

            "prognosis" => $request->prognosis,
            "prognosis_ttd" => $request->prognosis_ttd,

            "alternatif_dan_risiko" => $request->alternatif_dan_risiko,
            "alternatif_dan_risiko_ttd" => $request->alternatif_dan_risiko_ttd,

            "menyatakan_menerangkan_ttd" => $request->menyatakan_menerangkan_ttd,
            "menyatakan_memahami_ttd" => $request->menyatakan_memahami_ttd,

            "yang_bertanda_tangan" => $request->yang_bertanda_tangan,
            "berumur" => $request->berumur,
            "jenis_kelamin" => $request->jenis_kelamin,
            "menyatakan" => $request->menyatakan,
            "dilakukan_tindakan" => $request->dilakukan_tindakan,

            "yang_menyatakan" => $request->yang_menyatakan,
            "yang_menyatakan_ttd" => $request->yang_menyatakan_ttd,

            "saksi_1" => $request->saksi_1,
            "saksi_1_ttd" => $request->saksi_1_ttd,

            "saksi_2" => $request->saksi_2,
            "saksi_2_ttd" => $request->saksi_2_ttd,

            "lainlain" => $request->lainlain,
            "lainlain_ttd" => $request->lainlain_ttd,
        ]);
    }
}
