<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PEMBERIAN EDUKASI PASIEN TERINTEGRASI</title>
    <style>
        @page { margin: 14px; size: A4 landscape; }
        body { margin: 14px; font-family: Arial, sans-serif; font-size: 8pt; }

        .wrap { width: 100%; }
        .no-surat { text-align: right; font-size: 8pt; margin-bottom: 3px; }

        /* Main table */
        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }
        .tablee th, .tablee td {
            border: 1px solid black;
            padding: 3px 4px;
            vertical-align: top;
            font-size: 7.5pt;
        }
        .tablee th {
            text-align: center;
            font-weight: bold;
            background: #f0f0f0;
        }

        .kode-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .kategori-title { font-weight: bold; color: #1a3a6e; margin-bottom: 2px; font-size: 7.5pt; }
        .sub-items { margin: 2px 0 0 10px; padding: 0; font-size: 7pt; }
        .sub-items li { margin-bottom: 1px; list-style-type: none; }

        .ttd-img {
            max-width: 80px;
            height: auto;
            display: block;
            margin: 1px auto;
        }

        .ts-small {
            font-size: 6.5pt;
            color: #555;
            display: block;
            text-align: center;
        }

        .cb-item { margin-bottom: 2px; font-size: 7pt; }

        .kode-legend { font-size: 7pt; margin-top: 4px; color: #333; }
    </style>
</head>
<body>
<?php
$fullpath = storage_path('app/public/images/header_rme.png');
?>

<div class="wrap">
    <div class="no-surat">{{ $data->no_surat ?? 'RM 6.6/PEPT/22' }}</div>

    @include('print-rekam-medis.partials.header8')

    <table class="tablee">
        <thead>
            <tr>
                <th rowspan="2" style="width:22%;">Materi Edukasi</th>
                <th colspan="2" style="width:7%;">Bukti Sudah Diberikan</th>
                <th rowspan="2" style="width:8%;">Tanggal<br>Edukasi</th>
                <th rowspan="2" style="width:8%;">Metode<br>Edukasi</th>
                <th rowspan="2" style="width:11%;">Evaluasi</th>
                <th rowspan="2" style="width:8%;">Tanggal<br>Re-Edukasi</th>
                <th rowspan="2" style="width:18%;">Paraf / Nama Edukator</th>
                <th rowspan="2" style="width:18%;">Paraf / Nama Pasien / Keluarga</th>
            </tr>
            <tr>
                <th style="width:3.5%;">Ya</th>
                <th style="width:3.5%;">Tidak</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data->edukasi_sections ?? [] as $sec)
            <tr>
                {{-- Materi Edukasi --}}
                <td>
                    <div class="kategori-title">{{ $sec['kategori'] ?? '' }}</div>
                    @if(!empty($sec['sub_items']))
                        <ul class="sub-items">
                            @foreach ($sec['sub_items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if(($sec['kategori'] ?? '') === 'Perawat')
                        <ul class="sub-items">
                            <li>a. Pendidikan kesehatan tentang:</li>
                            @if(!empty($sec['extra']['topik1']))
                                <li>&nbsp;&nbsp;- {{ $sec['extra']['topik1'] }}</li>
                            @endif
                            @if(!empty($sec['extra']['topik2']))
                                <li>&nbsp;&nbsp;- {{ $sec['extra']['topik2'] }}</li>
                            @endif
                        </ul>
                    @endif
                    @if(($sec['kategori'] ?? '') === 'Rehabilitasi Medik' && !empty($sec['extra']['lainnya']))
                        <ul class="sub-items">
                            <li>d. {{ $sec['extra']['lainnya'] }}</li>
                        </ul>
                    @endif
                </td>

                {{-- Bukti Ya --}}
                <td style="text-align:center;">
                    <input type="checkbox" {{ ($sec['bukti'] ?? '') === 'ya' ? 'checked' : '' }}>
                </td>

                {{-- Bukti Tidak --}}
                <td style="text-align:center;">
                    <input type="checkbox" {{ ($sec['bukti'] ?? '') === 'tidak' ? 'checked' : '' }}>
                </td>

                {{-- Tanggal Edukasi --}}
                <td style="text-align:center;">
                    {{ !empty($sec['tanggal_edukasi']) ? \Carbon\Carbon::parse($sec['tanggal_edukasi'])->format('d/m/Y') : '' }}
                </td>

                {{-- Metode Edukasi --}}
                <td style="text-align:center;">
                    {{ $sec['metode_edukasi'] ?? '' }}
                </td>

                {{-- Evaluasi --}}
                <td style="padding:2px;">
                    <table style="width:100%; border-collapse:collapse;">
                        @foreach (['Sudah Mengerti', 'Re-Demonstrasi', 'Re-Edukasi'] as $opt)
                        <tr>
                            <td style="border:none; width:18px; padding:1px 2px; vertical-align:middle;">
                                <input type="checkbox" {{ ($sec['evaluasi'] ?? '') === $opt ? 'checked' : '' }}>
                            </td>
                            <td style="border:none; font-size:7pt; padding:1px 2px; vertical-align:middle;">
                                {{ $opt }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </td>

                {{-- Tanggal Re-Edukasi --}}
                <td style="text-align:center;">
                    {{ !empty($sec['tanggal_re_edukasi']) ? \Carbon\Carbon::parse($sec['tanggal_re_edukasi'])->format('d/m/Y') : '' }}
                </td>

                {{-- Paraf/Nama Edukator --}}
                <td style="text-align:center;">
                    @if(!empty($sec['ttd_edukator']))
                        <img src="{{ $sec['ttd_edukator'] }}" class="ttd-img" alt="TTD Edukator">
                        @if(!empty($sec['ttd_edukator_timestamp']))
                            <small class="ts-small">{{ $sec['ttd_edukator_timestamp'] }}</small>
                        @endif
                    @endif
                    @if(!empty($sec['nama_edukator']))
                        <br><strong>{{ $sec['nama_edukator'] }}</strong>
                    @endif
                </td>

                {{-- Paraf/Nama Pasien/Keluarga --}}
                <td style="text-align:center;">
                    @if(!empty($sec['ttd_pasien']))
                        <img src="{{ $sec['ttd_pasien'] }}" class="ttd-img" alt="TTD Pasien">
                        @if(!empty($sec['ttd_pasien_timestamp']))
                            <small class="ts-small">{{ $sec['ttd_pasien_timestamp'] }}</small>
                        @endif
                    @endif
                    @if(!empty($sec['nama_pasien_keluarga']))
                        <br><strong>{{ $sec['nama_pasien_keluarga'] }}</strong>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center; color:#999;">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="kode-legend">
        <strong>Kode :</strong>
        • Diskusi (D) &nbsp;&nbsp;
        • Demo (Demonstrasi) &nbsp;&nbsp;
        • Ceramah (C) &nbsp;&nbsp;
        • Simulasi (S) &nbsp;&nbsp;
        • Observasi (O) &nbsp;&nbsp;
        • Praktek Langsung (PL)
    </div>
</div>
</body>
</html>
