<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS - PROTOKOL TINDAKAN TERAPI</title>
    <style>
        @page { margin: 18px 22px; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 10.5pt;
            color: #000;
        }

        .wrap { width: 100%; }

        /* Header kanan atas - identitas pasien */
        .header-patient {
            float: right;
            border: 1px solid #000;
            padding: 6px 12px;
            font-size: 10pt;
            line-height: 1.8;
            min-width: 200px;
            margin-bottom: 5px;
        }

        .no-surat {
            text-align: right;
            font-size: 10pt;
            margin-bottom: 3px;
        }

        .clearfix::after { content: ""; display: table; clear: both; }

        /* Tabel utama */
        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        .tablee td, .tablee th {
            padding: 7px 10px;
            vertical-align: top;
            font-size: 10.5pt;
        }

        .tablee th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .title-row {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            background: #fff;
            padding: 10px;
        }

        .label-col { width: 220px; font-weight: normal; }
        .colon-col { width: 10px; }
        .value-col  { }

        .inner-table { width: 100%; border-collapse: collapse; }
        .inner-table td { border: none; padding: 2px 0; vertical-align: top; }

        .dotted-line {
            border-bottom: 1px dotted #000;
            min-height: 16px;
            display: block;
            width: 100%;
            padding: 2px 0;
        }

        .ttd-section {
            padding: 15px 10px 10px 10px;
        }
 
        .ttd-date {
            text-align: center;
            margin-bottom: 30px;
            font-size: 10.5pt;
        }
 
        .ttd-columns {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
 
        .ttd-columns td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;   /* semua konten rata bawah */
            padding: 0 30px;
        }
 
        .ttd-role {
            font-size: 10.5pt;
            margin-bottom: 8px;
            display: block;
        }
 
        /* Kotak area tanda tangan — tinggi tetap agar garis nama sejajar */
        .ttd-area {
            height: 75px;
            display: flex;
            align-items: flex-end;    /* TTD menempel ke garis bawah */
            justify-content: center;
        }
 
        .ttd-img {
            max-width: 150px;
            max-height: 70px;
            display: block;
        }
 
        /* Garis nama */
        .ttd-line {
            border-top: 1px solid #000;
            padding-top: 4px;
            margin-top: 0;
            display: block;
            font-size: 10.5pt;
        }
 
        .ttd-caption {
            font-size: 9.5pt;
            margin-top: 4px;
            color: #333;
        }
    </style>
</head>
<body>
<?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>

<div class="wrap">
    <!-- Nomor Surat kanan atas -->
    <div class="no-surat">RM 9.6/PTT/{{ config('app.tahun_akreditasi', '22') }}</div>
        @include('print-rekam-medis.partials.header')
    </div>

    <!-- Tabel Utama -->
    <table class="tablee">
        <tr><td colspan="3" style="height: 5px;"></td></tr>
        
        <!-- Judul -->
        <tr>
            <td colspan="3" class="title-row">PROTOKOL TINDAKAN TERAPI</td>
        </tr>
        <tr><td colspan="3" style="height: 5px;"></td></tr>


        <!-- Perusahaan -->
        <tr>
            <td class="label-col">Perusahaan</td>
            <td class="colon-col">:</td>
            <td>{{ $data->perusahaan ?? '' }}</td>
        </tr>

        <!-- No Kartu -->
        <tr>
            <td class="label-col">No Kartu</td>
            <td class="colon-col">:</td>
            <td>{{ $data->no_kartu ?? '' }}</td>
        </tr>

        <!-- Tanggal / Jam Masuk -->
        <tr>
            <td class="label-col">Tanggal / Jam Masuk</td>
            <td class="colon-col">:</td>
            <td>
                {{ $data->tanggal_jam_masuk
                    ? \Carbon\Carbon::parse($data->tanggal_jam_masuk)->format('d/m/Y H:i')
                    : '' }}
            </td>
        </tr>

        <!-- Ruang / Kelas -->
        <tr>
            <td class="label-col">Ruang / Kelas</td>
            <td class="colon-col">:</td>
            <td>{{ $data->ruang_kelas ?? '' }}</td>
        </tr>

        <!-- Keluhan Pasien -->
        <tr>
            <td class="label-col">Keluhan Pasien</td>
            <td class="colon-col">:</td>
            <td>{{ $data->keluhan_pasien ?? '' }}</td>
        </tr>

        <!-- Pengobatan -->
        <tr>
            <td class="label-col">Pengobatan yang telah diberikan</td>
            <td class="colon-col">:</td>
            <td>{{ $data->pengobatan_diberikan ?? '' }}</td>
        </tr>

        <!-- Tindakan Medis -->
        <tr>
            <td class="label-col">Tindakan Medis yang dilakukan</td>
            <td class="colon-col">:</td>
            <td>{{ $data->tindakan_medis ?? '' }}</td>
        </tr>

        <!-- Biaya -->
        <tr>
            <td class="label-col">Biaya yang diperlukan</td>
            <td class="colon-col">:</td>
            <td>{{ $data->biaya_diperlukan ?? '' }}</td>
        </tr>

        <!-- Alasan Tindakan -->
        <tr>
            <td class="label-col">Mohon jelaskan alasan tindakan diatas</td>
            <td class="colon-col">:</td>
            <td>{{ $data->alasan_tindakan ?? '' }}</td>
        </tr>

        <!-- Diagnosa Sementara -->
        <tr>
            <td class="label-col">Diagnosa Sementara</td>
            <td class="colon-col">:</td>
            <td>{{ $data->diagnosa_sementara ?? '' }}</td>
        </tr>
        <tr><td colspan="3" style="height: 160px;"></td></tr>

        <!-- Tanda Tangan -->
        <tr>
            <td colspan="3" class="ttd-section">
 
                <div class="ttd-date" style="height: 50px;">
                    Medan,
                    {{ $data->tanggal_surat
                        ? \Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->isoFormat('D MMMM YYYY')
                        : '___________________' }}
                </div>
 
                <table class="ttd-columns">
                    <tr>
                        <td>
                            <span class="ttd-role">Dokter Yang Merawat</span>
                            <div class="ttd-area">
                                @if($data->ttd_dokter)
                                    <img src="{{ $data->ttd_dokter }}" class="ttd-img" alt="TTD Dokter">
                                @endif
                            </div>
                            <span class="ttd-line">( {{ $data->nama_dokter_merawat ?? '' }} )</span>
                        </td>
 
                        <td>
                            <span class="ttd-role">
                                @if($data->status_persetujuan === 'disetujui')
                                    <strong>DISETUJUI</strong>
                                @elseif($data->status_persetujuan === 'tidak_disetujui')
                                    <strong>TIDAK DISETUJUI</strong>
                                @endif
                                Oleh
                            </span>
                            <div class="ttd-area">
                                @if($data->ttd_penyetuju)
                                    <img src="{{ $data->ttd_penyetuju }}" class="ttd-img" alt="TTD Penyetuju">
                                @endif
                            </div>
                            <span class="ttd-line">( {{ $data->nama_penyetuju ?? '' }} )</span>
                        </td>
                    </tr>
                </table>
 
            </td>
        </tr>
        <tr><td colspan="3" style="height: 120px;"></td></tr>
    </table>
</div>
</body>
</html>
