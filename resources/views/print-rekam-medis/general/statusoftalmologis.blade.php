<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>STATUS OFTALMOLOGIS RAWAT JALAN</title>
    <style>
        @page {
            margin: 18px;
        }

        body {
            margin: 18px;
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }

        .right {
            display: inline-block;
            float: right;
        }

        .eye-print-canvas {
            position: relative;
            width: 280px;
            height: 120px;
        }

        .eye-print-canvas img {
            position: absolute;
            top: 0;
            left: 0;
        }

        .eye-bg {
            width: 100%;
            height: 100%;
        }

        .eye-draw {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">

        {{-- ── Nomor Surat ── --}}
        <div style="width:100%; text-align:right; margin-bottom:5px; font-size:10pt;">
            {{ $data->no_surat ?? 'RM 1.4/SORJ/' . config('app.tahun_akreditasi', '22') }}
        </div>

        {{-- ── Header RS + Identitas Pasien ── --}}
        @include('print-rekam-medis.partials.header')

        <br>

        {{-- ── Judul + Tanggal Kunjungan ── --}}
        <table style="width:100%; border-collapse:collapse; margin-top:6px;">
            <tr>
                <td style="width:60%; font-size:13pt; font-weight:bold; text-decoration:underline; padding:4px 0;">
                    STATUS OFTALMOLOGIS RAWAT JALAN
                </td>
                <td style="width:40%; border:1px solid black; padding:6px 10px; font-size:10pt; text-align:left;">
                    Tanggal Kunjungan:
                    @if($data->tanggal_kunjungan)
                        {{ \Carbon\Carbon::parse($data->tanggal_kunjungan)->locale('id')->isoFormat('D/M/YYYY') }}
                    @else
                        ………………
                    @endif
                    &nbsp;&nbsp; jam
                    {{ $data->jam_kunjungan ?: '………' }}
                    &nbsp; WIB
                </td>
            </tr>
        </table>

        <br>

        {{-- ── OCULAR DEXTRA  &  OCULAR SINISTRA ── --}}
        <table style="width:100%; border-collapse:collapse; border:1px solid black;">
            <tr>

                {{-- OD --}}
                <td style="width:50%; border-right:1px solid black; padding:8px 10px; vertical-align:top;">
                    <table style="width:100%; border-collapse:collapse;">
                        <tr>
                            <td style="font-weight:bold; font-size:11pt;">OCULAR DEXTRA</td>
                            <td style="text-align:right;">
                                <span style="border:1px solid black; padding:3px 8px; font-size:10pt; white-space:nowrap;">
                                    PD : {{ $data->od_pd ?: '………' }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table style="width:100%; border-collapse:collapse; font-size:10pt; line-height:22px;">
                        <tr>
                            <td>
                                Autoref:
                                @php
                                    $ar = array_filter([$data->od_autoref_s, $data->od_autoref_c, $data->od_autoref_x]);
                                    echo $ar ? implode(' / ', $ar) : '………………………………………';
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Keratometri: &nbsp; K1: {{ $data->od_kk1 ?: '………' }} @ {{ $data->od_kk1_axis ?: '…………' }}<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                K2: {{ $data->od_kk2 ?: '………' }} @ {{ $data->od_kk2_axis ?: '…………' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top:6px;">
                                Tonometri: {{ $data->od_tonometri ?: '………' }} MmHg
                            </td>
                        </tr>
                        <tr>
                            <td><strong>VISUS : {{ $data->od_visus ?: '………' }}</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>BCVA : {{ $data->od_bcva ?: '………………………………' }} &#8594; ……...</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Add: {{ $data->od_add ?: '……………' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="padding-top:6px;">
                                Kacamata lama: Sph : {{ $data->od_kacamata_sph ?: '……' }}
                                &nbsp; Cyl: {{ $data->od_kacamata_cyl ?: '……' }}
                                &nbsp; x {{ $data->od_kacamata_x ?: '……' }}<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Addisi: {{ $data->od_kacamata_addisi ?: '……………' }}
                            </td>
                        </tr>
                    </table>
                </td>

                {{-- OS --}}
                <td style="width:50%; padding:8px 10px; vertical-align:top;">
                    <table style="width:100%; border-collapse:collapse;">
                        <tr>
                            <td style="font-weight:bold; font-size:11pt;">OCULAR SINISTRA</td>
                            <td style="text-align:right;">
                                <span style="border:1px solid black; padding:3px 8px; font-size:10pt; white-space:nowrap;">
                                    RO: {{ $data->os_pd ?: '……………' }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table style="width:100%; border-collapse:collapse; font-size:10pt; line-height:22px;">
                        <tr>
                            <td>
                                Autoref:
                                @php
                                    $ar2 = array_filter([$data->os_autoref_s, $data->os_autoref_c, $data->os_autoref_x]);
                                    echo $ar2 ? implode(' / ', $ar2) : '………………………………………';
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Keratometri: &nbsp; K1: {{ $data->os_kk1 ?: '………' }} @ {{ $data->os_kk1_axis ?: '…………' }}<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                K2: {{ $data->os_kk2 ?: '………' }} @ {{ $data->os_kk2_axis ?: '………' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top:6px;">
                                Tonometri: {{ $data->os_tonometri ?: '………' }} MmHg
                            </td>
                        </tr>
                        <tr>
                            <td><strong>VISUS : {{ $data->os_visus ?: '………' }}</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>BCVA : {{ $data->os_bcva ?: '………………………………' }} &#8594; ……...</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Add: {{ $data->os_add ?: '……………' }}</strong></td>
                        </tr>
                        <tr>
                            <td style="padding-top:6px;">
                                Kacamata lama: Sph : {{ $data->os_kacamata_sph ?: '……' }}
                                &nbsp; Cyl: {{ $data->os_kacamata_cyl ?: '….' }}
                                &nbsp; x {{ $data->os_kacamata_x ?: '…..' }}<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Addisi: {{ $data->os_kacamata_addisi ?: '…………' }}
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
        </table>

        <br>

        {{-- ── POSISI DAN PERGERAKAN BOLA MATA ── --}}
        <table style="width:100%; border-collapse:collapse; border:1px solid black;">
            <tr>
                <td style="width:45%; padding:10px 12px; vertical-align:middle; font-size:10pt; line-height:24px;">
                    POSISI DAN PERGERAKAN<br>
                    BOLA MATA: &nbsp;
                    <input type="checkbox" {{ $data->posisi_normal ? 'checked' : '' }}>
                    &nbsp; Normal &nbsp;
                    <input type="checkbox" {{ !$data->posisi_normal ? 'checked' : '' }}>
                </td>
                <td style="width:55%; padding:6px; text-align:center; vertical-align:middle;">
                    @if($data->diagram_mata)
                        <div class="eye-print-canvas" style="margin:0 auto;">
                            <img src="{{ public_path('images/eye-both-background.svg') }}" class="eye-bg"
                                 onerror="this.style.display='none'">
                            <img src="{{ $data->diagram_mata }}" class="eye-draw">
                        </div>
                    @else
                        <div style="width:280px; height:100px; border:1px dashed #ccc; margin:0 auto; display:inline-block;"></div>
                    @endif
                </td>
            </tr>
        </table>

        <br>

        {{-- ── STATUS TABLE ── --}}
        <table style="width:100%; border-collapse:collapse; border:1px solid black; font-size:10pt;">
            <thead>
                <tr>
                    <th style="border:1px solid black; padding:6px 10px; text-align:left; width:25%; font-weight:bold; text-decoration:underline;">
                        STATUS
                    </th>
                    <th style="border:1px solid black; padding:6px 10px; text-align:left; width:37.5%; font-weight:bold; text-decoration:underline;">
                        OCULAR DEXTRA
                    </th>
                    <th style="border:1px solid black; padding:6px 10px; text-align:left; width:37.5%; font-weight:bold; text-decoration:underline;">
                        OCULAR SINISTRA
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                $statusRows = [
                    ['key' => 'palpebra',    'label' => 'PALPEBRA'],
                    ['key' => 'conjunctiva', 'label' => 'CONJUNCTIVA'],
                    ['key' => 'cornea',      'label' => 'CORNEA'],
                    ['key' => 'bmd',         'label' => 'BILIK MATA DEPAN'],
                    ['key' => 'pupil_iris',  'label' => 'PUPIL DAN IRIS'],
                    ['key' => 'lensa',       'label' => 'LENSA'],
                    ['key' => 'vitreous',    'label' => 'VITREOUS'],
                    ['key' => 'funduscopy',  'label' => 'FUNDUSCOPY'],
                ];
                @endphp

                @foreach($statusRows as $row)
                @php
                    $odKey  = 'status_' . $row['key'] . '_od_normal';
                    $osKey  = 'status_' . $row['key'] . '_os_normal';
                    $ketKey = 'status_' . $row['key'] . '_ket';
                    $odNormal = $data->$odKey ?? false;
                    $osNormal = $data->$osKey ?? false;
                    $ket      = $data->$ketKey ?? '';
                @endphp
                <tr>
                    <td style="border:1px solid black; padding:6px 10px;">{{ $row['label'] }}</td>
                    <td style="border:1px solid black; padding:6px 16px;">
                        <input type="checkbox" {{ $odNormal ? 'checked' : '' }}>
                        &nbsp; Normal &nbsp;
                        <input type="checkbox" {{ !$odNormal ? 'checked' : '' }}>
                        @if($ket && !$odNormal)
                            <br><small style="font-size:8pt; color:#333;">{{ $ket }}</small>
                        @endif
                    </td>
                    <td style="border:1px solid black; padding:6px 16px;">
                        <input type="checkbox" {{ $osNormal ? 'checked' : '' }}>
                        &nbsp; Normal &nbsp;
                        <input type="checkbox" {{ !$osNormal ? 'checked' : '' }}>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <br>
        <br>

        {{-- ── Page 2 content: Klinis ── --}}
        <table style="width:100%; border-collapse:collapse; border:1px solid black; font-size:10pt; line-height:24px;">
            <tr>
                <td style="padding:10px 14px;">

                    PEMERIKSAAN PENUNJANG:
                    {{ $data->pemeriksaan_penunjang ?: '…………………………………………………………………………………………………………' }}
                    <br>
                    ………………………………………………………………………………………………………………………..
                    <br><br>

                    DIAGNOSE KERJA:
                    {{ $data->diagnose_kerja ?: '…………………………………………………………' }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    KODE ICD 10:
                    {{ $data->diagnose_kerja_icd ?: '………..' }}
                    <br>
                    ………………………………………………………………………………………………………………………...
                    <br><br>

                    DIAGNOSE BANDING:
                    {{ $data->diagnose_banding ?: '…………………………………………………………' }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    KODE ICD 10:
                    {{ $data->diagnose_banding_icd ?: '………' }}
                    <br>
                    ………………………………………………………………………………………………………………………...
                    <br><br>

                    TATA LAKSANA:
                    <br>
                    @if($data->tata_laksana)
                        {{ $data->tata_laksana }}
                    @else
                        ……………………………………………………………………………………………………………………………...<br>
                        &nbsp; …………………………………………………………………………………………………………………..<br>
                        ……………………………………………………………………………………………………………………………...<br>
                        ……………………………………………………………………………………………………………………………...
                    @endif
                    <br><br>

                    PERENCANAAN:
                    <br>
                    @if($data->perencanaan)
                        {{ $data->perencanaan }}
                    @else
                        ……………………………………………………………………………………………………………………………...<br>
                        …………………………………………………………………………………………………………………………..<br>
                    @endif
                    <br>

                    PROGNOSA:
                    {{ $data->prognosa ?: '…………………………………………………………' }}
                    <br>

                </td>
            </tr>
        </table>

        <br>

        {{-- ── Tanda Tangan Dokter ── --}}
        <table style="width:100%; border-collapse:collapse; font-size:10pt;">
            <tr>
                <td style="width:45%; border:1px solid black; padding:10px 12px; vertical-align:top;">
                    <strong>TANDA TANGAN DAN NAMA DOKTER VERIFIKASI</strong>
                    <span style="font-size:9pt;">(STEMPEL, NAMA/ PARAF)</span>
                    <br><br><br><br>
                    @if($data->ttd_dokter)
                        <img src="{{ $data->ttd_dokter }}" alt="TTD Dokter" style="max-width:180px; max-height:80px;">
                        <br>
                    @else
                        <br><br>
                    @endif
                    …………………………………………
                    @if($data->nama_dokter)
                        <br>{{ $data->nama_dokter }}
                    @endif
                </td>
                <td style="width:55%;"></td>
            </tr>
        </table>

    </div>
</body>
</html>
