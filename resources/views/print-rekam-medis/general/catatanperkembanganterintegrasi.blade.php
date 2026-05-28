<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CATATAN PERKEMBANGAN TERINTEGRITASI</title>
    <style>
        @page { margin: 18px; }
        body { margin: 18px; font-family: Arial, sans-serif; font-size: 9pt; }

        .wrap { width: 100%; }

        .no-surat { text-align: right; font-size: 9pt; margin-bottom: 4px; }

        .patient-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        .patient-table td { font-size: 9pt; padding: 1px 4px; }
        .pt-label { width: 80px; font-weight: bold; }
        .pt-colon { width: 8px; }

        h3 { text-align: center; font-size: 11pt; margin: 6px 0; }
        .subtitle { text-align: center; font-size: 7.5pt; color: #333; margin-bottom: 6px; }

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        .tablee th, .tablee td {
            border: 1px solid black;
            padding: 4px 5px;
            vertical-align: top;
            font-size: 8.5pt;
        }

        .tablee th {
            text-align: center;
            font-weight: bold;
            background: #f0f0f0;
        }

        .ttd-img {
            max-width: 90px;
            height: auto;
            display: block;
            margin: 2px auto;
        }

        .ts-small {
            font-size: 7pt;
            color: #555;
            display: block;
            text-align: center;
        }

        .stempel-img {
            max-width: 120px;
            width: 120px;
            height: auto;
            display: block;
            margin: 4px auto;
            opacity: 0.8;
        }
    </style>
</head>
<body>
<?php
$fullpath     = storage_path('app/public/images/header_rme.png');
$stempelPath  = public_path('storage/images/logo_antrian.png');
$stempelB64   = file_exists($stempelPath)
    ? 'data:image/png;base64,' . base64_encode(file_get_contents($stempelPath))
    : '';
?>

<div class="wrap">
    <div class="no-surat">{{ $data->no_surat ?? 'RM 6.7/CPT/' . config('app.tahun_akreditasi', '22') }}</div>

    @include('print-rekam-medis.partials.header')

    <p style="font-size:8pt; text-align:center; margin:2px 0;">(Diisi dalam waktu 24 jam pertama pasien masuk rawat inap/jalan)</p>

    <h3>CATATAN PERKEMBANGAN TERINTEGRITASI</h3>
    <p class="subtitle">
        Ditulis Berdasarkan prinsip S (Subjective / Anamnesis), O (Objective / Hasil pemeriksaan), A (Analisa) dan<br>
        P (Planning / Rencana, tatalaksana / Instruksi dengan Target terukur) dan ADIME dari masing-masing masalah<br>
        (Assesmen, Diagnosis, Intervensi, Monitoring dan Evaluasi)
    </p>

    <table class="tablee">
        <thead>
            <tr>
                <th rowspan="2" style="width:9%;">Tanggal<br>/Jam</th>
                <th colspan="2" style="width:68%;">
                    Hasil Pemeriksaan, Analisis, Rencana Penatalaksanaan Pasien<br>
                    <span style="font-weight:normal;">(Bubuhkan Stempel, Nama, dan Paraf pada Setiap Akhir Catatan)</span>
                </th>
                <th rowspan="2" style="width:23%;">
                    VERIFIKASI<br>
                    <span style="font-weight:normal;">(Stempel, Nama/Paraf)</span>
                </th>
            </tr>
            <tr>
                <th style="width:34%;">Dokter</th>
                <th style="width:34%;">Profesi Lain / Case Manager</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data->cppt_rows ?? [] as $row)
            <tr>
                <td style="text-align:center;">
                    {{ !empty($row['tanggal']) ? \Carbon\Carbon::parse($row['tanggal'])->format('d/m/Y') : '' }}
                    <br>{{ $row['jam'] ?? '' }}
                </td>
                <td>
                    {!! nl2br(e($row['isian_dokter'] ?? '')) !!}
                    @if(!empty($row['nama_dokter']))
                        <br><br><strong>{{ $row['nama_dokter'] }}</strong>
                    @endif
                    @if(!empty($row['ttd_dokter']))
                        <br><img src="{{ $row['ttd_dokter'] }}" class="ttd-img" alt="TTD Dokter">
                        @if(!empty($row['ttd_dokter_timestamp']))
                            <small class="ts-small">{{ $row['ttd_dokter_timestamp'] }}</small>
                        @endif
                    @endif
                </td>
                <td>
                    {!! nl2br(e($row['isian_profesi_lain'] ?? '')) !!}
                    @if(!empty($row['profesi_jabatan']))
                        <br><em style="font-size:7.5pt;">({{ $row['profesi_jabatan'] }})</em>
                    @endif
                    @if(!empty($row['nama_profesi_lain']))
                        <br><br><strong>{{ $row['nama_profesi_lain'] }}</strong>
                    @endif
                    @if(!empty($row['ttd_profesi_lain']))
                        <br><img src="{{ $row['ttd_profesi_lain'] }}" class="ttd-img" alt="TTD Profesi Lain">
                        @if(!empty($row['ttd_profesi_lain_timestamp']))
                            <small class="ts-small">{{ $row['ttd_profesi_lain_timestamp'] }}</small>
                        @endif
                    @endif
                </td>
                <td style="text-align:center;">
                    @if(!empty($row['ttd_verifikasi']))
                        <img src="{{ $row['ttd_verifikasi'] }}" class="ttd-img" alt="TTD Verifikasi">
                        @if(!empty($row['ttd_verifikasi_timestamp']))
                            <small class="ts-small">{{ $row['ttd_verifikasi_timestamp'] }}</small>
                        @endif
                    @endif
                    @if(!empty($row['stempel_verifikasi']) && $row['stempel_verifikasi'] && $stempelB64)
                        <img src="{{ $stempelB64 }}" class="stempel-img" alt="Stempel">
                    @endif
                    @if(!empty($row['nama_verifikasi']))
                        <br><strong>{{ $row['nama_verifikasi'] }}</strong>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; color:#999;">Belum ada catatan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p style="font-size:7.5pt; text-align:center; margin-top:6px; color:#555;">
        Terimakasih atas kerjasamanya telah mengisi formulir ini dengan benar dan jelas
    </p>
</div>
</body>
</html>
