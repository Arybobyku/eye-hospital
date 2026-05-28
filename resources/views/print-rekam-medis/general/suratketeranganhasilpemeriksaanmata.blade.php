<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SURAT KETERANGAN HASIL PEMERIKSAAN MATA</title>
    <style>
        @page { margin: 20px 25px; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 10.5pt;
            color: #000;
        }

        .wrap { width: 100%; }

        .no-surat {
            text-align: right;
            font-size: 10pt;
            margin-bottom: 4px;
        }

        .clearfix::after { content: ""; display: table; clear: both; }

        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            margin: 14px 0 16px 0;
            text-decoration: underline;
        }

        .pasfoto-box {
            float: left;
            width: 113px;
            height: 151px;
            border: 1px solid #000;
            text-align: center;
            line-height: 151px;
            font-size: 9pt;
            color: #555;
            margin-left: 306px;
            margin-bottom: 8px;
            overflow: hidden;
        }

        .pasfoto-box img {
            width: 113px;
            height: 151px;
            object-fit: cover;
            display: block;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 3px 6px;
            vertical-align: top;
            font-size: 10.5pt;
            border: none;
        }

        .label-col { width: 200px; }
        .colon-col { width: 10px; }

        .section-head {
            font-weight: bold;
            margin: 14px 0 6px 0;
            font-size: 10.5pt;
        }

        .bullet-item {
            margin: 3px 0 3px 12px;
            font-size: 10.5pt;
        }

        .sub-item {
            margin: 2px 0 2px 28px;
            font-size: 10.5pt;
        }

        .sub-table {
            width: 100%;
            border-collapse: collapse;
            margin-left: 28px;
        }

        .sub-table td {
            border: none;
            padding: 2px 4px;
            font-size: 10.5pt;
            vertical-align: top;
        }

        .label-sub { width: 220px; }
        .colon-sub { width: 10px; }

        .kesimpulan-block {
            margin-top: 12px;
        }

        .kesimpulan-block .k-label {
            font-weight: bold;
            font-size: 10.5pt;
        }

        .isi-text {
            min-height: 18px;
            display: block;
            padding: 2px 0;
        }

        .ttd-section {
            margin-top: 24px;
            text-align: right;
            padding-right: 5%;
        }

        .ttd-kota {
            margin-bottom: 6px;
            font-size: 10.5pt;
        }

        .ttd-label {
            margin-bottom: 60px;
            font-size: 10.5pt;
        }

        .ttd-img {
            max-width: 150px;
            max-height: 75px;
            display: block;
            margin: 0 auto 4px auto;
        }

        .ttd-nama {
            display: inline-block;
            border-top: 1px solid #000;
            min-width: 200px;
            text-align: center;
            padding-top: 4px;
            font-size: 10.5pt;
        }
    </style>
</head>
<body>
<?php $fullpath = storage_path('app/public/images/header_rme3.png'); ?>

<div class="wrap">
    <div class="no-surat">RM 9.2/SKHPM/{{ config('app.tahun_akreditasi', '22') }}</div>

    @include('print-rekam-medis.partials.header3')

    <div class="judul">SURAT KETERANGAN HASIL PEMERIKSAAN MATA</div>

    <p style="margin: 0 0 10px 0; font-size:10.5pt; padding-left:10px;">
        Yang bertanda tangan di bawah ini menerangkan bahwa:
    </p>

    <!-- Pasfoto float kanan -->
    <div class="clearfix">

        <!-- Data Pasien -->
        <table class="data-table" style="padding-left:10px;">
            <tr>
                <td class="label-col">Nama</td>
                <td class="colon-col">:</td>
                <td>{{ $data->nama ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">Tempat / Tanggal Lahir</td>
                <td class="colon-col">:</td>
                <td>
                    {{ $data->tempat_lahir ?? '' }}
                    @if($data->tempat_lahir && $data->tanggal_lahir), @endif
                    {{ $data->tanggal_lahir ? \Carbon\Carbon::parse($data->tanggal_lahir)->locale('id')->isoFormat('D MMMM YYYY') : '' }}
                </td>
            </tr>
            <tr>
                <td class="label-col">Alamat</td>
                <td class="colon-col">:</td>
                <td>{{ $data->alamat ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">No Kartu Identitas</td>
                <td class="colon-col">:</td>
                <td>{{ $data->nik ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">No Rekam Medis</td>
                <td class="colon-col">:</td>
                <td>{{ $data->no_rm ?? '' }}</td>
            </tr>
        </table>
    </div>

    <p style="margin: 14px 0 8px 0; font-size:10.5pt; padding-left:10px;">
        Telah dilakukan pemeriksaan mata dengan hasil sebagai berikut:
    </p>

    <!-- Visual Acuity -->
    <div class="bullet-item">• <strong>Visual Acuity / Tajam Penglihatan</strong></div>
    <table class="sub-table">
        <tr>
            <td class="label-sub">• Mata kanan / Ocular Dextra</td>
            <td class="colon-sub">:</td>
            <td>{{ $data->va_od ?? '' }}
                @if($data->koreksi_od)
                    &nbsp;&nbsp; Koreksi kacamata: {{ $data->koreksi_od }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="label-sub">• Mata kiri / Ocular Sinistra</td>
            <td class="colon-sub">:</td>
            <td>{{ $data->va_os ?? '' }}
                @if($data->koreksi_os)
                    &nbsp;&nbsp; Koreksi kacamata: {{ $data->koreksi_os }}
                @endif
            </td>
        </tr>
    </table>

    <!-- Tekanan Bola Mata -->
    <div class="bullet-item" style="margin-top:8px;">• <strong>Tekanan bola mata</strong></div>
    <table class="sub-table">
        <tr>
            <td class="label-sub">• Mata kanan / Ocular Dextra</td>
            <td class="colon-sub">:</td>
            <td>{{ $data->tio_od ?? '' }} mmHg</td>
        </tr>
        <tr>
            <td class="label-sub">• Mata kiri / Ocular Sinistra</td>
            <td class="colon-sub">:</td>
            <td>{{ $data->tio_os ?? '' }} mmHg</td>
        </tr>
    </table>

    <!-- Penglihatan Warna -->
    <div class="bullet-item" style="margin-top:8px;">
        • <strong>Penglihatan warna / Color vision test with Ishihara Test:</strong>
        {{ $data->penglihatan_warna ?? '' }}
    </div>

    <!-- Kesimpulan -->
    <div class="kesimpulan-block" style="margin-top:16px; padding-left:10px;">
        <span class="k-label">KESIMPULAN:</span><br>
        <span class="isi-text">{{ $data->kesimpulan ?? '' }}</span>
    </div>

    <!-- Saran -->
    <div class="kesimpulan-block" style="margin-top:12px; padding-left:10px;">
        <span class="k-label">SARAN:</span><br>
        <span class="isi-text">{{ $data->saran ?? '' }}</span>
    </div>

    <!-- TTD -->
    <div class="ttd-section">
        
        <div class="pasfoto-box">
            @if($data->pasfoto)
                @php
                    $pasfotoPath = storage_path('app/public/' . $data->pasfoto);
                    $ext = strtolower(pathinfo($pasfotoPath, PATHINFO_EXTENSION));
                    $mime = $ext === 'png' ? 'image/png' : 'image/jpeg';
                    $pasfotoSrc = file_exists($pasfotoPath)
                        ? 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($pasfotoPath))
                        : null;
                @endphp
                @if($pasfotoSrc)
                    <img src="{{ $pasfotoSrc }}" alt="Pasfoto">
                @else
                    Pasfoto<br>4×6 cm
                @endif
            @else
                Pasfoto<br>4×6 cm
            @endif
        </div>
        <div class="ttd-kota">
            Medan,
            {{ $data->tanggal_surat
                ? \Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->isoFormat('D MMMM YYYY')
                : '___________________' }}
        </div>
        <div class="ttd-label">Salam Sejawat,</div>

        @if($data->ttd_dokter)
            <img src="{{ $data->ttd_dokter }}" class="ttd-img" alt="TTD">
        @else
            <div style="height: 60px;"></div>
        @endif

        <div>
            <span class="ttd-nama">( {{ $data->nama_dokter ?? '' }} )</span>
        </div>
    </div>
</div>
</body>
</html>
