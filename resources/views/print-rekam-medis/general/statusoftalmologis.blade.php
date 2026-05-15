<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>STATUS OFTALMOLOGIS RAWAT JALAN</title>
    <style>
        @page { margin: 18px; }
        body { margin: 18px; font-family: Arial, sans-serif; font-size: 10pt; color: #000; }

        .wrap { width: 100%; display: inline-block; }
        .no-surat { text-align: right; font-size: 9pt; margin-bottom: 4px; }
        .form-title { font-weight: bold; text-align: center; font-size: 13pt; margin: 6px 0 2px; }
        .form-subtitle { text-align: center; font-size: 9pt; margin-bottom: 8px; }

        /* ── Identitas ── */
        .identity-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; font-size: 9pt; }
        .identity-table td { padding: 2px 6px; }
        .identity-table .lbl { font-weight: bold; width: 120px; }
        .identity-table .colon { width: 10px; }
        .identity-table .val { border-bottom: 1px solid #999; }

        /* ── OD / OS grid ── */
        .od-os-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; font-size: 9pt; }
        .od-os-table th {
            background: #dbeafe; font-weight: bold; text-align: center;
            padding: 4px 6px; border: 1px solid #93c5fd;
        }
        .od-os-table th.os-hdr { background: #dcfce7; border-color: #86efac; }
        .od-os-table td { padding: 3px 6px; border: 1px solid #d1d5db; vertical-align: top; }
        .od-os-table .row-lbl { font-weight: bold; width: 90px; }
        .od-os-table .val-cell { border-bottom: 1px solid #bbb; min-width: 80px; display: inline-block; }

        /* ── Status table ── */
        .status-tbl { width: 100%; border-collapse: collapse; font-size: 9pt; margin-bottom: 8px; }
        .status-tbl th {
            background: #eff6ff; color: #1e40af; padding: 4px 8px;
            border: 1px solid #bfdbfe; font-weight: bold; text-align: center;
        }
        .status-tbl td { padding: 4px 8px; border: 1px solid #e5e7eb; }
        .status-tbl tr:nth-child(even) td { background: #fafafa; }
        .cb-cell { text-align: center; }

        /* ── Section headings ── */
        .section-heading {
            font-weight: bold; font-size: 10pt; color: #1e40af;
            border-left: 4px solid #1e40af; padding-left: 6px;
            margin: 10px 0 5px;
        }

        /* ── Klinis block ── */
        .klinis-table { width: 100%; border-collapse: collapse; font-size: 9pt; margin-bottom: 8px; }
        .klinis-table td { padding: 3px 6px; vertical-align: top; }
        .klinis-table .lbl { font-weight: bold; width: 160px; }
        .klinis-table .colon { width: 10px; }
        .klinis-table .val {
            border-bottom: 1px solid #ccc; min-height: 18px; padding-bottom: 2px;
        }
        .block-val {
            border: 1px solid #ccc; border-radius: 4px; min-height: 36px;
            padding: 4px 6px; margin: 2px 0 6px; font-size: 9pt;
        }

        /* ── Diagram ── */
        .diagram-wrapper {
            position: relative; width: 460px; height: 160px;
            border: 1px solid #ccc; margin: 6px auto;
        }
        .diagram-wrapper img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }

        /* ── TTD ── */
        .ttd-area { margin-top: 20px; text-align: right; }
        .ttd-box { display: inline-block; text-align: center; min-width: 200px; }
        .ttd-box img { max-width: 180px; border: 1px solid #e2e8f0; }
        .ttd-name { border-top: 1px solid #000; margin-top: 4px; padding-top: 2px;
                    font-size: 10pt; font-weight: bold; }
    </style>
</head>
<body>
<div class="wrap">

    <!-- ── Nomor Surat ── -->
    <div class="no-surat">
        {{ $data->no_surat ?? 'RM 1.4/SORJ/' . config('app.tahun_akreditasi', '22') }}
    </div>

    {{-- @include('print-rekam-medis.partials.header') --}}

    <div class="form-title">STATUS OFTALMOLOGIS RAWAT JALAN</div>
    <div class="form-subtitle">Prima Vision Eye Hospital</div>
    <hr style="border:1.5px solid #000; margin:4px 0 8px"/>

    <!-- ── Identitas Pasien ── -->
    <table class="identity-table">
        <tr>
            <td class="lbl">Nama</td><td class="colon">:</td>
            <td class="val">{{ $data->nama ?? ($pasien->nama ?? '-') }}</td>
            <td width="20"></td>
            <td class="lbl">No. Rekam Medis</td><td class="colon">:</td>
            <td class="val">{{ $data->no_rm ?? ($pasien->rekam_medis ?? '-') }}</td>
        </tr>
        <tr>
            <td class="lbl">Tanggal Lahir</td><td class="colon">:</td>
            <td class="val">
                @if($data->tanggal_lahir)
                    {{ \Carbon\Carbon::parse($data->tanggal_lahir)->locale('id')->isoFormat('D MMMM YYYY') }}
                @else - @endif
            </td>
            <td></td>
            <td class="lbl">Jenis Kelamin</td><td class="colon">:</td>
            <td class="val">
                @php
                    $jk = $data->jenis_kelamin ?? ($pasien->jenis_kelamin ?? '');
                    echo $jk === 'L' ? 'Laki-laki' : ($jk === 'P' ? 'Perempuan' : $jk);
                @endphp
            </td>
        </tr>
        <tr>
            <td class="lbl">NIK</td><td class="colon">:</td>
            <td class="val">{{ $data->nik ?? ($pasien->no_ktp ?? '-') }}</td>
            <td></td>
            <td class="lbl">Tgl Kunjungan</td><td class="colon">:</td>
            <td class="val">
                @if($data->tanggal_kunjungan)
                    {{ \Carbon\Carbon::parse($data->tanggal_kunjungan)->locale('id')->isoFormat('D MMMM YYYY') }}
                    @if($data->jam_kunjungan) — {{ $data->jam_kunjungan }} WIB @endif
                @else - @endif
            </td>
        </tr>
    </table>

    <!-- ── Pemeriksaan Refraksi ── -->
    <div class="section-heading">Pemeriksaan Refraksi &amp; Tekanan Intraokuler</div>
    <table class="od-os-table">
        <thead>
            <tr>
                <th style="width:30%">Pemeriksaan</th>
                <th style="width:35%">OCULAR DEXTRA (OD / Kanan)</th>
                <th class="os-hdr" style="width:35%">OCULAR SINISTRA (OS / Kiri)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="row-lbl">PD (mm)</td>
                <td>{{ $data->od_pd ?: '-' }}</td>
                <td>{{ $data->os_pd ?: '-' }}</td>
            </tr>
            <tr>
                <td class="row-lbl">Autoref (S/C×Axis)</td>
                <td>
                    @php
                        $odAR = array_filter([$data->od_autoref_s, $data->od_autoref_c, $data->od_autoref_x]);
                        echo $odAR ? implode(' / ', $odAR) : '-';
                    @endphp
                </td>
                <td>
                    @php
                        $osAR = array_filter([$data->os_autoref_s, $data->os_autoref_c, $data->os_autoref_x]);
                        echo $osAR ? implode(' / ', $osAR) : '-';
                    @endphp
                </td>
            </tr>
            <tr>
                <td class="row-lbl">Keratometri</td>
                <td>
                    @if($data->od_kk1)K1: {{ $data->od_kk1 }} @ {{ $data->od_kk1_axis }}<br>@endif
                    @if($data->od_kk2)K2: {{ $data->od_kk2 }} @ {{ $data->od_kk2_axis }}@endif
                    @if(!$data->od_kk1 && !$data->od_kk2)-@endif
                </td>
                <td>
                    @if($data->os_kk1)K1: {{ $data->os_kk1 }} @ {{ $data->os_kk1_axis }}<br>@endif
                    @if($data->os_kk2)K2: {{ $data->os_kk2 }} @ {{ $data->os_kk2_axis }}@endif
                    @if(!$data->os_kk1 && !$data->os_kk2)-@endif
                </td>
            </tr>
            <tr>
                <td class="row-lbl">Tonometri (MmHg)</td>
                <td>{{ $data->od_tonometri ?: '-' }}</td>
                <td>{{ $data->os_tonometri ?: '-' }}</td>
            </tr>
            <tr>
                <td class="row-lbl">VISUS</td>
                <td>{{ $data->od_visus ?: '-' }}</td>
                <td>{{ $data->os_visus ?: '-' }}</td>
            </tr>
            <tr>
                <td class="row-lbl">BCVA</td>
                <td>→ {{ $data->od_bcva ?: '-' }}</td>
                <td>→ {{ $data->os_bcva ?: '-' }}</td>
            </tr>
            <tr>
                <td class="row-lbl">Add</td>
                <td>{{ $data->od_add ?: '-' }}</td>
                <td>{{ $data->os_add ?: '-' }}</td>
            </tr>
            <tr>
                <td class="row-lbl">Kacamata Lama</td>
                <td>
                    @if($data->od_kacamata_sph || $data->od_kacamata_cyl)
                        Sph {{ $data->od_kacamata_sph }} / Cyl {{ $data->od_kacamata_cyl }} × {{ $data->od_kacamata_x }}<br>
                        Addisi: {{ $data->od_kacamata_addisi ?: '-' }}
                    @else - @endif
                </td>
                <td>
                    @if($data->os_kacamata_sph || $data->os_kacamata_cyl)
                        Sph {{ $data->os_kacamata_sph }} / Cyl {{ $data->os_kacamata_cyl }} × {{ $data->os_kacamata_x }}<br>
                        Addisi: {{ $data->os_kacamata_addisi ?: '-' }}
                    @else - @endif
                </td>
            </tr>
        </tbody>
    </table>

    <!-- ── Posisi Bola Mata ── -->
    <div class="section-heading">Posisi dan Pergerakan Bola Mata</div>
    <p style="font-size:9pt; margin:2px 0 4px;">
        Normal: <input type="checkbox" {{ $data->posisi_normal ? 'checked' : '' }}>
    </p>
    @if($data->diagram_mata)
    <div class="diagram-wrapper">
        <img src="/images/eye-both-background.svg" alt="bg" onerror="this.style.display='none'" />
        <img src="{{ $data->diagram_mata }}" alt="diagram" />
    </div>
    @endif

    <!-- ── Status Segmen ── -->
    <div class="section-heading">Status Segmen Anterior &amp; Posterior</div>
    <table class="status-tbl">
        <thead>
            <tr>
                <th style="width:28%; text-align:left">PEMERIKSAAN</th>
                <th style="width:12%">OD Normal</th>
                <th style="width:12%">OS Normal</th>
                <th style="text-align:left">Keterangan</th>
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
                $odKey = 'status_' . $row['key'] . '_od_normal';
                $osKey = 'status_' . $row['key'] . '_os_normal';
                $ketKey = 'status_' . $row['key'] . '_ket';
            @endphp
            <tr>
                <td style="font-weight:bold">{{ $row['label'] }}</td>
                <td class="cb-cell"><input type="checkbox" {{ $data->$odKey ? 'checked' : '' }}></td>
                <td class="cb-cell"><input type="checkbox" {{ $data->$osKey ? 'checked' : '' }}></td>
                <td>{{ $data->$ketKey ?: '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ── Klinis ── -->
    <div class="section-heading">Pemeriksaan Penunjang</div>
    <div class="block-val">{{ $data->pemeriksaan_penunjang ?: '' }}</div>

    <div class="section-heading">Diagnosa</div>
    <table class="klinis-table">
        <tr>
            <td class="lbl">Diagnose Kerja</td><td class="colon">:</td>
            <td class="val">{{ $data->diagnose_kerja ?: '-' }}</td>
            <td width="20"></td>
            <td class="lbl" style="width:80px">Kode ICD-10</td><td class="colon">:</td>
            <td class="val" style="width:80px">{{ $data->diagnose_kerja_icd ?: '-' }}</td>
        </tr>
        <tr>
            <td class="lbl">Diagnose Banding</td><td class="colon">:</td>
            <td class="val">{{ $data->diagnose_banding ?: '-' }}</td>
            <td></td>
            <td class="lbl">Kode ICD-10</td><td class="colon">:</td>
            <td class="val">{{ $data->diagnose_banding_icd ?: '-' }}</td>
        </tr>
    </table>

    <div class="section-heading">Tata Laksana</div>
    <div class="block-val">{{ $data->tata_laksana ?: '' }}</div>

    <div class="section-heading">Perencanaan</div>
    <div class="block-val">{{ $data->perencanaan ?: '' }}</div>

    <table class="klinis-table">
        <tr>
            <td class="lbl">Prognosa</td><td class="colon">:</td>
            <td class="val">{{ $data->prognosa ?: '-' }}</td>
        </tr>
    </table>

    <!-- ── Tanda Tangan ── -->
    <div class="ttd-area">
        <div class="ttd-box">
            <p style="margin:0 0 4px; font-size:9pt">Tanda Tangan Dokter Verifikasi</p>
            @if($data->ttd_dokter)
                <img src="{{ $data->ttd_dokter }}" alt="TTD Dokter" />
            @else
                <div style="height:60px; border:1px dashed #ccc;"></div>
            @endif
            <div class="ttd-name">( {{ $data->nama_dokter ?? '-' }} )</div>
        </div>
    </div>

</div>
</body>
</html>
