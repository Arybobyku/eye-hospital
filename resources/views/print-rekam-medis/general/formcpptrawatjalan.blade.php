<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CPPT RAWAT JALAN</title>
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
            max-width: 100px;
            height: auto;
            display: block;
            margin: 2px auto;
        }
    </style>
</head>
<body>
<?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>

<div class="wrap">
    <div class="no-surat">{{ $data->no_surat ?? 'RM 1.5/CPPTRJ/' . config('app.tahun_akreditasi', '22') }}</div>

    @include('print-rekam-medis.partials.header')

    <table class="patient-table">
        <tr>
            <td class="pt-label">Nama</td>
            <td class="pt-colon">:</td>
            <td>{{ $data->nama ?? '' }}</td>
            <td class="pt-label">No. RM</td>
            <td class="pt-colon">:</td>
            <td>{{ $data->no_rm ?? '' }}</td>
        </tr>
        <tr>
            <td class="pt-label">Tgl Lahir</td>
            <td class="pt-colon">:</td>
            <td>{{ $data->tanggal_lahir ? \Carbon\Carbon::parse($data->tanggal_lahir)->format('d/m/Y') : '' }}</td>
            <td class="pt-label">NIK</td>
            <td class="pt-colon">:</td>
            <td>{{ $data->nik ?? '' }}</td>
        </tr>
    </table>

    <h3>CATATAN PERKEMBANGAN PASIEN TERINTEGRASI RAWAT JALAN</h3>

    <table class="tablee">
        <thead>
            <tr>
                <th style="width:9%;">Tanggal<br>/Jam</th>
                <th style="width:9%;">Profesional<br>Pemberi Asuhan<br>(PPA)</th>
                <th style="width:34%;">
                    Hasil Asesmen Pasien dan Pemberian Pelayanan<br>
                    <span style="font-weight:normal;">(Tulis dengan Format SOAP/ADIME, Disertai Sasaran, Tulis Nama, Beri Paraf Pada Akhir Catatan)</span>
                </th>
                <th style="width:34%;">
                    Instruksi PPA Termasuk Pasca Bedah<br>
                    <span style="font-weight:normal;">(Instruksi Ditulis dengan Rinci dan Jelas)</span>
                </th>
                <th style="width:14%;">
                    Review &amp; Verifikasi DPJP<br>
                    <span style="font-weight:normal;">(Tulis Nama, Beri Paraf, Tgl/Jam)</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data->cppt_rows ?? [] as $row)
            <tr>
                <td>
                    {{ !empty($row['tanggal']) ? \Carbon\Carbon::parse($row['tanggal'])->format('d/m/Y') : '' }}
                    <br>{{ $row['jam'] ?? '' }}
                </td>
                <td>{{ $row['profesi'] ?? '' }}</td>
                <td>{!! nl2br(e($row['hasil_asesmen'] ?? '')) !!}</td>
                <td>
                    {!! nl2br(e($row['instruksi_ppa'] ?? '')) !!}
                    @if(!empty($row['nama_ppa']))
                        <br><br><strong>{{ $row['nama_ppa'] }}</strong>
                    @endif
                    @if(!empty($row['ttd_ppa']))
                        <br><img src="{{ $row['ttd_ppa'] }}" class="ttd-img" alt="TTD PPA">
                        @if(!empty($row['ttd_ppa_timestamp']))
                            <br><small style="font-size:7pt; color:#555;">{{ $row['ttd_ppa_timestamp'] }}</small>
                        @endif
                    @endif
                </td>
                <td style="text-align:center;">
                    @if(!empty($row['ttd_dpjp']))
                        <img src="{{ $row['ttd_dpjp'] }}" class="ttd-img" alt="TTD DPJP">
                        @if(!empty($row['ttd_dpjp_timestamp']))
                            <br><small style="font-size:7pt; color:#555;">{{ $row['ttd_dpjp_timestamp'] }}</small>
                        @endif
                    @endif
                    <strong>{{ $row['nama_dpjp'] ?? '' }}</strong><br>
                    @if(!empty($row['tanggal_review']))
                        {{ \Carbon\Carbon::parse($row['tanggal_review'])->format('d/m/Y') }}
                    @endif
                    {{ $row['jam_review'] ?? '' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; color:#999;">Belum ada catatan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($data->catatan_khusus)
    <div style="margin-top:8px; font-size:9pt;">
        <strong>Catatan Khusus:</strong> {{ $data->catatan_khusus }}
    </div>
    @endif
</div>
</body>
</html>
