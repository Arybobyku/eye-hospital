<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS - FORMULIR KONSUL DAN JAWABAN KONSUL</title>
    <style>
        @page { margin: 18px 22px; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 10.5pt;
            color: #000;
        }

        .wrap { width: 100%; }

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

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        .tablee td, .tablee th {
            border: none;
            padding: 6px 10px;
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
            padding: 8px;
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            font-size: 11pt;
            background: #f0f0f0;
            padding: 6px;
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .label-col { width: 220px; }
        .colon-col { width: 10px; }

        .ttd-img {
            max-width: 160px;
            max-height: 80px;
            display: block;
            margin: 5px auto;
        }

        .ttd-nama {
            border-top: 1px solid #000;
            display: inline-block;
            min-width: 180px;
            padding-top: 4px;
            text-align: center;
        }

        .checkbox-row { display: inline-block; margin-right: 20px; }
    </style>
</head>
<body>
<?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>

<div class="wrap">
    <div class="no-surat">RM 10.2/FKDJK/{{ config('app.tahun_akreditasi', '22') }}</div>

    <div class="clearfix">
        @include('print-rekam-medis.partials.header')
    </div>

    <!-- ===== FORMULIR KONSUL ===== -->
    <table class="tablee">
        <tr>
            <td colspan="3" class="section-title">FORMULIR KONSUL</td>
        </tr>

        <tr>
            <td colspan="3" style="padding: 6px 10px;">
                TS. Dr. <strong>{{ $data->dokter_tujuan_konsul ?? '___________________________' }}</strong> Yth.
            </td>
        </tr>

        <tr>
            <td colspan="3" style="padding: 6px 10px;">
                Mohon &nbsp;&nbsp;
                <span class="checkbox-row">
                    [{{ $data->jenis_konsul == '1' ? 'X' : ' ' }}] 1) Konsul Saja
                </span>
                <span class="checkbox-row">
                    [{{ $data->jenis_konsul == '2' ? 'X' : ' ' }}] 2) Pengobatan bersama selanjutnya
                </span>
                <span class="checkbox-row">
                    [{{ $data->jenis_konsul == '3' ? 'X' : ' ' }}] 3) Ambil Alih
                </span>
            </td>
        </tr>

        <tr>
            <td class="label-col">Pasien Nama</td>
            <td class="colon-col">:</td>
            <td>{{ $data->nama ?? '' }}</td>
        </tr>
        <tr>
            <td class="label-col">Tgl. Lahir / L-P</td>
            <td class="colon-col">:</td>
            <td>
                {{ $data->tanggal_lahir ? \Carbon\Carbon::parse($data->tanggal_lahir)->format('d/m/Y') : '' }}
                &nbsp;&nbsp;/ {{ $data->jenis_kelamin ?? '' }}
            </td>
        </tr>
        <tr>
            <td class="label-col">Diagnosa</td>
            <td class="colon-col">:</td>
            <td>{{ $data->diagnosa ?? '' }}</td>
        </tr>
        <tr>
            <td class="label-col">Dengan Persangkaan kami menderita</td>
            <td class="colon-col">:</td>
            <td>{{ $data->persangkaan_diagnosis ?? '' }}</td>
        </tr>
        <tr>
            <td class="label-col">Pada pasien kami dapati hal-hal sebagai berikut</td>
            <td class="colon-col">:</td>
            <td>{{ $data->temuan_klinis ?? '' }}</td>
        </tr>
        <tr>
            <td class="label-col">Pengobatan / Tindakan Pembedahan yang telah kami berikan</td>
            <td class="colon-col">:</td>
            <td>{{ $data->pengobatan_tindakan_sebelumnya ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="3" style="padding: 12px 10px;">
                <div style="text-align: right; margin-bottom: 16px; padding-right: 3%;">
                    Medan,
                    {{ $data->tanggal_konsul
                        ? \Carbon\Carbon::parse($data->tanggal_konsul)->locale('id')->isoFormat('D MMMM YYYY')
                        : '___________________' }}
                    &nbsp; / Jam : {{ $data->jam_konsul ?? '______' }}
                </div>
                <div style="text-align: right;">
                    <div style="margin-bottom: 4px; font-size:10.5pt; padding-right: 3%;">Salam Sejawat,</div>

                    @if($data->ttd_dokter_pengirim)
                        <img src="{{ $data->ttd_dokter_pengirim }}" class="ttd-img" style="margin-left:auto; margin-right:8%;" alt="TTD">
                    @else
                        <div style="height: 70px;"></div>
                    @endif

                    <div style="text-align:right; padding-right: 3%;">
                        <span class="ttd-nama">( {{ $data->nama_dokter_pengirim ?? '' }} )</span>
                    </div>
                    <div style="font-size:9.5pt; text-align:right; padding-right:3%;">Nama Jelas dan Tanda Tangan Dokter</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- ===== PAGE BREAK — FORMULIR JAWABAN KONSUL ===== -->
    <div style="page-break-before: always;"></div>

    <!-- Header halaman 2 -->
    <div class="no-surat">RM 10.2/FKDJK/{{ config('app.tahun_akreditasi', '22') }}</div>
    <div class="clearfix">
        @include('print-rekam-medis.partials.header')
    </div>

    <!-- ===== FORMULIR JAWABAN KONSUL ===== -->
    <table class="tablee" style="margin-top: 10px;">
        <tr>
            <td colspan="3" class="section-title">FORMULIR JAWABAN KONSUL</td>
        </tr>

        <tr>
            <td colspan="3" style="padding: 6px 10px;">
                TS. Dr. <strong>{{ $data->dokter_tujuan_jawaban ?? '___________________________' }}</strong> Yth.
            </td>
        </tr>

        <tr>
            <td colspan="3" style="padding: 6px 10px;">
                Sehubungan dengan permintaan konsul TS, tanggal
                <strong>
                    {{ $data->tanggal_permintaan_konsul_ref
                        ? \Carbon\Carbon::parse($data->tanggal_permintaan_konsul_ref)->format('d/m/Y')
                        : '..................' }}
                </strong>
            </td>
        </tr>

        <tr>
            <td class="label-col">Pasien Nama</td>
            <td class="colon-col">:</td>
            <td>{{ $data->nama ?? '' }}</td>
        </tr>
        <tr>
            <td class="label-col">Tgl. Lahir</td>
            <td class="colon-col">:</td>
            <td>{{ $data->tanggal_lahir ? \Carbon\Carbon::parse($data->tanggal_lahir)->format('d/m/Y') : '' }}</td>
        </tr>
        <tr>
            <td class="label-col">Kami sampaikan sebagai berikut</td>
            <td class="colon-col">:</td>
            <td>{{ $data->hasil_konsul ?? '' }}</td>
        </tr>
        <tr>
            <td class="label-col">Berdasarkan hal-hal tersebut, kami anjurkan dilakukan pemeriksaan / tindakan pembedahan</td>
            <td class="colon-col">:</td>
            <td>{{ $data->anjuran_pemeriksaan_tindakan ?? '' }}</td>
        </tr>
        <tr>
            <td class="label-col">Juga kami anjurkan konsultasi TS</td>
            <td class="colon-col">:</td>
            <td>
                {{ $data->anjuran_konsul_lanjut_dokter ?? '' }}
                @if($data->anjuran_konsul_lanjut_bagian)
                    &nbsp; Bagian: {{ $data->anjuran_konsul_lanjut_bagian }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="label-col">Therapy / Tindakan yang kami anjurkan</td>
            <td class="colon-col">:</td>
            <td>{{ $data->terapi_anjuran ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="3" style="padding: 12px 10px; padding-right:3%;">
                <div style="text-align: right; margin-bottom: 16px; padding-right:3%;">
                    Medan,
                    {{ $data->tanggal_jawaban
                        ? \Carbon\Carbon::parse($data->tanggal_jawaban)->locale('id')->isoFormat('D MMMM YYYY')
                        : '___________________' }}
                    &nbsp; / Jam : {{ $data->jam_jawaban ?? '______' }}
                </div>
                <div style="text-align: right;">
                    <div style="margin-bottom: 4px; font-size:10.5pt; padding-right:3%;">Salam Sejawat,</div>

                    @if($data->ttd_dokter_konsultan)
                        <img src="{{ $data->ttd_dokter_konsultan }}" class="ttd-img" style="margin-left:auto; margin-right:8%;" alt="TTD">
                    @else
                        <div style="height: 70px;"></div>
                    @endif

                    <div style="text-align:right; padding-right:3%;">
                        <span class="ttd-nama">( {{ $data->nama_dokter_konsultan ?? '' }} )</span>
                    </div>
                    <div style="font-size:9.5pt; text-align:right; padding-right:3%;">Nama Jelas dan Tanda Tangan Dokter</div>
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
