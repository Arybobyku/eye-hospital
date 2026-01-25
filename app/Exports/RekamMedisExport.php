<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekamMedisExport implements FromGenerator, ShouldAutoSize, WithHeadings
{
    public function __construct(private $col){}

    public function generator(): \Generator
    {
        for($i = 0; $i < $this->col->count(); $i++){
            yield [
                $i + 1,
                $this->col[$i]->tanggal,
                $this->col[$i]->no_pendaftaran,
                $this->col[$i]->rekam_medis,
                $this->col[$i]->nama_pasien,
                $this->col[$i]->pemeriksaan_diagnosa,
                $this->col[$i]->jenis_kelamin,
                $this->col[$i]->kelompok_umur_nama,
                $this->col[$i]->agama,
                $this->col[$i]->status_pernikahan,
                $this->col[$i]->pekerjaan,
                $this->col[$i]->alamat,
                $this->col[$i]->nama_kecamatan,
                $this->col[$i]->nama_kab_kota,
                $this->col[$i]->cara_masuk,
                $this->col[$i]->jalur_masuk,
                $this->col[$i]->nama_pj,
                $this->col[$i]->rujukan,
                $this->col[$i]->kasus_urgent,
                $this->col[$i]->carabayar_nama,
                $this->col[$i]->ruang_poliklinik,
                $this->col[$i]->nama_dokter,
                $this->col[$i]->tanggal_bayar,
                $this->col[$i]->status,
            ];
        }
    }

    public function headings(): array{
        return [
            'No',
            'Waktu Pendaftaran',
            'No Pendaftaran',
            'Rekam Medis',
            'Nama Pasien',
            'Diagnosa',
            'Jenis Kelamin',
            'Golongan Umur',
            'Agama',
            'Status Perkawinan',
            'Pekerjaan',
            'Alamat Lengkap',
            'Alamat Lengkap',
            'Kab / Kota',
            'Cara Masuk',
            'Kunjungan',
            'Penanggung Jawab',
            'Nama Perujuk',
            'Jenis Kasus',
            'Cara Bayar',
            'Nama Ruangan',
            'Nama Dokter'
        ];
    }
}
