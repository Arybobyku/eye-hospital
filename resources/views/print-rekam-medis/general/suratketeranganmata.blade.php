<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SURAT KETERANGAN HASIL PEMERIKSAAN MATA</title>
    <style>
        @page { margin: 20px 25px 10px 25px; }

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

        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            margin: 14px 0 20px 0;
            text-decoration: underline;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .data-table td {
            padding: 4px 6px;
            vertical-align: top;
            font-size: 10.5pt;
            border: none;
        }

        .label-col { width: 200px; }
        .colon-col { width: 12px; }

        .hasil-block {
            margin-top: 14px;
        }

        .hasil-label {
            font-weight: bold;
            font-size: 10.5pt;
            margin-bottom: 6px;
        }

        .hasil-table {
            width: 100%;
            border-collapse: collapse;
            margin-left: 16px;
        }

        .hasil-table td {
            border: none;
            padding: 3px 6px;
            font-size: 10.5pt;
            vertical-align: top;
        }

        .hl-col { width: 220px; }
        .hc-col { width: 12px; }

        .diagnosa-block {
            margin-top: 14px;
            font-size: 10.5pt;
        }

        .pernyataan-block {
            margin-top: 20px;
            font-size: 10.5pt;
            font-style: italic;
        }

        .ttd-section {
            margin-top: 20px;
            text-align: right;
            padding-right: 5%;
            width: 100%;
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
            width: 220px;       /* pakai width fix, bukan max-width */
            height: 160px;
            object-fit: contain;
            display: block;
            margin-left: auto;  /* ini yang dorong ke kanan */
            margin-right: 0;
        }

        .ttd-nama {
            display: inline-block;
            border-top: 1px solid #000;
            min-width: 200px;
            text-align: center;
            padding-top: 4px;
            font-size: 10.5pt;
        }

        .ttd-info {
            font-size: 10pt;
            margin-top: 3px;
        }
    </style>
</head>
<body>
<?php $fullpath = storage_path('app/public/images/header_rme3.png'); ?>

<div class="wrap">
    <div class="no-surat">RM 8.6/SKHPM/{{ config('app.tahun_akreditasi', '22') }}</div>

    @include('print-rekam-medis.partials.header3')

    <div class="judul">SURAT KETERANGAN HASIL PEMERIKSAAN MATA</div>

    <!-- Data Pasien -->
    <table class="data-table">
        <tr>
            <td class="label-col">Nama</td>
            <td class="colon-col">:</td>
            <td>{{ $data->nama ?? '' }}</td>
        </tr>
        <tr>
            <td class="label-col">Nomor Rekam Medis</td>
            <td class="colon-col">:</td>
            <td>{{ $data->no_rm ?? '' }}</td>
        </tr>
    </table>

    <!-- Hasil Pemeriksaan -->
    <div class="hasil-block">
        <div class="hasil-label">Hasil pemeriksaan :</div>
        <table class="hasil-table">
            <tr>
                <td class="hl-col">Autorefkeratometry OD</td>
                <td class="hc-col">:</td>
                <td>{{ $data->autorefkeratometry_od ?? '' }}</td>
            </tr>
            <tr>
                <td class="hl-col">Autorefkeratometry OS</td>
                <td class="hc-col">:</td>
                <td>{{ $data->autorefkeratometry_os ?? '' }}</td>
            </tr>
            <tr>
                <td class="hl-col">Visus OD</td>
                <td class="hc-col">:</td>
                <td>{{ $data->visus_od ?? '' }}</td>
            </tr>
            <tr>
                <td class="hl-col">Visus OS</td>
                <td class="hc-col">:</td>
                <td>{{ $data->visus_os ?? '' }}</td>
            </tr>
            <tr>
                <td class="hl-col">Tonometry OD</td>
                <td class="hc-col">:</td>
                <td>{{ $data->tonometry_od ?? '' }} MmHg</td>
            </tr>
            <tr>
                <td class="hl-col">Tonometry OS</td>
                <td class="hc-col">:</td>
                <td>{{ $data->tonometry_os ?? '' }} MmHg</td>
            </tr>
        </table>
    </div>

    <!-- Diagnosa -->
    <div class="diagnosa-block">
        <table class="data-table" style="margin-top:10px;">
            <tr>
                <td class="label-col">Diagnosa</td>
                <td class="colon-col">:</td>
                <td>{{ $data->diagnosa ?? '' }}</td>
            </tr>
        </table>
    </div>

    <!-- Pernyataan -->
    <div class="pernyataan-block">
        Demikian saya menyatakan bahwa seluruh jawaban di atas adalah benar menurut pengetahuan dan keyakinan saya.
    </div>

    <!-- TTD -->
    <div class="ttd-section">
        <div class="ttd-kota">
            Medan,
            {{ $data->tanggal_surat
                ? \Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->isoFormat('D MMMM YYYY')
                : '___________________' }}
        </div>
        <div class="ttd-label">Hormat saya,</div>

        @if($data->ttd_dokter)
            <img src="{{ $data->ttd_dokter }}" class="ttd-img" alt="TTD">
        @else
            <div style="height: 60px;"></div>
        @endif

        <div>
            <span class="ttd-nama">dr. {{ $data->nama_dokter ?? '' }}</span>
        </div>
        @if($data->email_dokter)
            <div class="ttd-info">Email: {{ $data->email_dokter }}</div>
        @endif
        @if($data->hp_dokter)
            <div class="ttd-info">Handphone: {{ $data->hp_dokter }}</div>
        @endif
    </div>
</div>

@include('print-rekam-medis.partials.footer')
</body>
</html>
