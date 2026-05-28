<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FORMULIR PENILAIAN RISIKO JATUH PASIEN GERIATRI</title>
    <style>
    @page { margin: 15px 18px; size: A4; }
    body  { margin: 0; font-family: Arial, sans-serif; font-size: 8.5pt; color: #000; }

    /* ===== CHECKMARK — DejaVu Sans bundled in dompdf, supports U+2713 ===== */
    .chk { font-family: 'DejaVu Sans', sans-serif; font-size: 10pt; font-weight: bold; }

    /* ===== HEADER ===== */
    .no-surat { text-align: right; font-size: 8pt; font-weight: bold; margin-bottom: 2px; }

    /* ===== FORM TITLE ===== */
    .form-title {
        text-align: center;
        font-size: 10pt;
        font-weight: bold;
        text-transform: uppercase;
        margin: 6px 0 3px 0;
        border: 1px solid #000;
        padding: 4px;
    }

    /* ===== MAIN PENILAIAN TABLE ===== */
    .penilaian-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 7.5pt;
        margin-top: 4px;
    }
    .penilaian-table td,
    .penilaian-table th {
        border: 1px solid #000;
        padding: 2px 3px;
        vertical-align: middle;
    }
    .penilaian-table th {
        background: #e0e0e0;
        text-align: center;
        font-weight: bold;
    }
    .col-no    { width: 20px;  text-align: center; }
    .col-skor  { width: 36px;  text-align: center; }
    .col-date  { width: 60px;  text-align: center; font-size: 7pt; }
    .col-check { text-align: center; }
    .center    { text-align: center; }
    .bold      { font-weight: bold; }

    /* ===== KETERANGAN ===== */
    .keterangan {
        font-size: 7.5pt;
        margin-top: 5px;
        padding: 3px 5px;
        border: 1px solid #888;
        line-height: 1.6;
    }

    /* ===== INTERVENSI TABLE ===== */
    .int-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 8pt;
        margin-top: 5px;
    }
    .int-table td {
        border: 1px solid #000;
        padding: 3px 5px;
        vertical-align: middle;
    }
    .int-label {
        font-weight: bold;
        background: #d8d8d8;
        font-size: 8.5pt;
    }
    .ya-tidak {
        width: 36px;
        text-align: center;
        font-weight: bold;
    }
    .sub-item { padding-left: 18px; font-size: 7.5pt; }

    /* ===== TTD ===== */
    .ttd-table { width: 100%; border-collapse: collapse; margin-top: 6px; }
    .ttd-table td { text-align: center; padding: 3px; vertical-align: bottom; }
    .ttd-img   { max-height: 50px; max-width: 120px; display: block; margin: 2px auto; }
    .ttd-line  { border-top: 1px solid #000; padding-top: 2px; font-size: 7.5pt; margin-top: 2px; }

    table { page-break-inside: auto; }
    tr    { page-break-inside: avoid; page-break-after: auto; }
    </style>
</head>
<body>
<?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>

@php
    /* ---- Skor bobot masing-masing item ---- */
    $itemsMap = [
        1  => ['label' => 'Gangguan gaya berjalan (diseret, menghentak, bergoyang)', 'skor' => 4],
        2  => ['label' => 'Pusing / pingsan pada posisi tegak',                       'skor' => 3],
        3  => ['label' => 'Kebingungan setiap saat',                                  'skor' => 3],
        4  => ['label' => 'Nokturia / Inkontinen',                                    'skor' => 3],
        5  => ['label' => 'Kebingungan intermiten',                                   'skor' => 2],
        6  => ['label' => 'Kelemahan umum',                                           'skor' => 2],
        7  => ['label' => 'Obat-obat berisiko tinggi (diuretik, narkotik, sedatif, anti psikotik, laksatif, vasodilator, antiaritmia, antihipertensi, obat hipoglikemik, obat tidur, antidepresan, neuroleptik, NSAID)', 'skor' => 2],
        8  => ['label' => 'Riwayat jatuh yang dialami dalam waktu 12 bulan',          'skor' => 2],
        9  => ['label' => 'Osteoporosis',                                             'skor' => 1],
        10 => ['label' => 'Gangguan pendengaran dan atau penglihatan',                'skor' => 1],
        11 => ['label' => 'Usia 70 tahun ke atas',                                   'skor' => 1],
    ];

    $skorMap = [1=>4, 2=>3, 3=>3, 4=>3, 5=>2, 6=>2, 7=>2, 8=>2, 9=>1, 10=>1, 11=>1];

    /* ---- Ambil penilaian_rows ---- */
    $penilaianRows = $data->penilaian_rows ?? [];
    if (is_string($penilaianRows)) {
        $penilaianRows = json_decode($penilaianRows, true) ?? [];
    }

    /* ---- Fallback data lama (kolom flat) ---- */
    if (empty($penilaianRows) && isset($data->item_1)) {
        $penilaianRows = [[
            'tanggal'               => optional($data->tanggal)->format('Y-m-d') ?? '',
            'jam'                   => $data->jam ?? '',
            'item_1'  => $data->item_1  ?? 0, 'item_2'  => $data->item_2  ?? 0,
            'item_3'  => $data->item_3  ?? 0, 'item_4'  => $data->item_4  ?? 0,
            'item_5'  => $data->item_5  ?? 0, 'item_6'  => $data->item_6  ?? 0,
            'item_7'  => $data->item_7  ?? 0, 'item_8'  => $data->item_8  ?? 0,
            'item_9'  => $data->item_9  ?? 0, 'item_10' => $data->item_10 ?? 0,
            'item_11' => $data->item_11 ?? 0,
            'nama_penilai'          => $data->nama_penilai          ?? '',
            'ttd_penilai'           => $data->ttd_penilai           ?? '',
            'ttd_penilai_timestamp' => $data->ttd_penilai_timestamp ?? '',
        ]];
    }

    /* ---- Hitung skor tiap kolom ---- */
    $skorPerRow = [];
    foreach ($penilaianRows as $row) {
        $total = 0;
        for ($i = 1; $i <= 11; $i++) {
            if (($row['item_'.$i] ?? 0) == 1) $total += $skorMap[$i];
        }
        $skorPerRow[] = $total;
    }

    function levelRisikoG(int $skor): string {
        if ($skor === 0) return 'Tidak Berisiko';
        if ($skor <= 3)  return 'Risiko Rendah';
        return 'Risiko Tinggi';
    }

    $colCount = count($penilaianRows);
@endphp

{{-- ===================================================== --}}
{{-- HALAMAN 1 : FORMULIR PENILAIAN RISIKO JATUH           --}}
{{-- ===================================================== --}}

<div class="no-surat">{{ $data->no_surat ?? 'RM 6.5/FPRJPG/22' }}</div>

@include('print-rekam-medis.partials.header')

<div class="form-title">FORMULIR PENILAIAN RISIKO JATUH PASIEN GERIATRI</div>

{{-- ---- Tabel Penilaian (Faktor risiko = baris, Penilaian = kolom) ---- --}}
<table class="penilaian-table">
    <thead>
        <tr>
            <th class="col-no" rowspan="3">No</th>
            <th rowspan="3" style="text-align:left;">RESIKO</th>
            <th class="col-skor" rowspan="3">SCORE</th>
            @if($colCount > 0)
                @foreach($penilaianRows as $idx => $row)
                <th class="col-date">TGL<br/>
                    {{ !empty($row['tanggal']) ? \Carbon\Carbon::parse($row['tanggal'])->format('d/m/Y') : '' }}
                </th>
                @endforeach
            @else
                <th class="col-date">TGL</th>
                <th class="col-date">TGL</th>
                <th class="col-date">TGL</th>
            @endif
        </tr>
        <tr>
            @if($colCount > 0)
                @foreach($penilaianRows as $idx => $row)
                <th class="col-date">JAM<br/>{{ $row['jam'] ?? '' }}</th>
                @endforeach
            @else
                <th class="col-date">JAM</th>
                <th class="col-date">JAM</th>
                <th class="col-date">JAM</th>
            @endif
        </tr>
        <tr>
            @if($colCount > 0)
                @foreach($penilaianRows as $idx => $row)
                <th class="col-date">SCORE</th>
                @endforeach
            @else
                <th class="col-date">SCORE</th>
                <th class="col-date">SCORE</th>
                <th class="col-date">SCORE</th>
            @endif
        </tr>
    </thead>
    <tbody>
        {{-- 11 baris faktor risiko --}}
        @foreach($itemsMap as $no => $item)
        <tr>
            <td class="col-no center">{{ $no }}</td>
            <td>{{ $item['label'] }}</td>
            <td class="col-skor center bold">{{ $item['skor'] }}</td>
            @if($colCount > 0)
                @foreach($penilaianRows as $idx => $row)
                <td class="col-check center">
                    {!! ($row['item_'.$no] ?? 0) == 1 ? '<span class="chk">&#10003;</span>' : '' !!}
                </td>
                @endforeach
            @else
                <td class="col-check"></td>
                <td class="col-check"></td>
                <td class="col-check"></td>
            @endif
        </tr>
        @endforeach

        {{-- Baris Jumlah Skor --}}
        <tr>
            <td colspan="2" style="text-align:right; font-weight:bold; padding-right:6px;">Jumlah Skor</td>
            <td class="center"></td>
            @if($colCount > 0)
                @foreach($skorPerRow as $sk)
                <td class="center bold" style="font-size:9pt;">{{ $sk }}</td>
                @endforeach
            @else
                <td class="col-check"></td>
                <td class="col-check"></td>
                <td class="col-check"></td>
            @endif
        </tr>

        {{-- Baris Tingkat Risiko --}}
        <tr>
            <td colspan="2" style="text-align:right; font-weight:bold; padding-right:6px;">Tingkat Risiko</td>
            <td class="center"></td>
            @if($colCount > 0)
                @foreach($skorPerRow as $sk)
                <td class="center" style="font-size:7pt;">{{ levelRisikoG($sk) }}</td>
                @endforeach
            @else
                <td class="col-check"></td>
                <td class="col-check"></td>
                <td class="col-check"></td>
            @endif
        </tr>

        {{-- Baris Nama Penilai --}}
        <tr>
            <td colspan="2" style="text-align:right; font-weight:bold; padding-right:6px;">Nama &amp; paraf yang<br/>melakukan penilaian</td>
            <td></td>
            @if($colCount > 0)
                @foreach($penilaianRows as $idx => $row)
                <td class="center" style="vertical-align:bottom; height:55px;">
                    @if(!empty($row['ttd_penilai']))
                        <img src="{{ $row['ttd_penilai'] }}" style="max-height:40px; max-width:55px; display:block; margin:0 auto;"/>
                    @endif
                    <div style="border-top:1px solid #000; font-size:7pt; padding-top:1px; margin-top:2px;">
                        {{ $row['nama_penilai'] ?? '' }}
                    </div>
                </td>
                @endforeach
            @else
                <td style="height:55px;"></td>
                <td></td>
                <td></td>
            @endif
        </tr>
    </tbody>
</table>

{{-- Keterangan risiko --}}
<div class="keterangan">
    <strong>Tingkat Risiko:</strong><br/>
    &nbsp;&nbsp;<span class="chk">&bull;</span> Tidak berisiko bila skor 0 &mdash; lakukan perawatan yang baik<br/>
    &nbsp;&nbsp;<span class="chk">&bull;</span> Risiko Rendah bila skor 1&ndash;3 &mdash; lakukan intervensi jatuh standar (lihat di balik halaman ini)<br/>
    &nbsp;&nbsp;<span class="chk">&bull;</span> Risiko Tinggi bila skor <span class="chk">&#8805;</span> 4 &mdash; lakukan intervensi jatuh risiko tinggi (lihat di balik halaman ini)
</div>


{{-- ===================================================== --}}
{{-- HALAMAN 2 : FORM PELAKSANAAN PENCEGAHAN JATUH         --}}
{{-- ===================================================== --}}
<div style="page-break-before: always;"></div>

<div class="no-surat">{{ $data->no_surat ?? 'RM 6.5/FPRJPG/22' }}</div>

@include('print-rekam-medis.partials.header')

<div class="form-title">FORM PELAKSANAAN PENCEGAHAN JATUH PASIEN GERIATRI</div>

<table class="int-table" style="margin-top:6px;">

    {{-- ===== SEKSI A ===== --}}
    <tr>
        <td colspan="2" class="int-label">
            A. Intervensi Jatuh Standar / Resiko Rendah: Skor 1&ndash;3
        </td>
        <td class="ya-tidak" style="background:#d8d8d8;">YA</td>
        <td class="ya-tidak" style="background:#d8d8d8;">TIDAK</td>
    </tr>

    <tr>
        <td class="col-no center">1.</td>
        <td>Menilai kembali risiko jatuh setiap pergantian shift</td>
        <td class="center">{!! $data->int_a1 == 1 ? '<span class="chk">&#10003;</span>' : '' !!}</td>
        <td class="center">{!! (($data->int_a1 === 0 || $data->int_a1 === '0') && $data->int_a1 !== null) ? '<span class="chk">&#10003;</span>' : '' !!}</td>
    </tr>

    <tr>
        <td class="col-no center">2.</td>
        <td>Memberikan edukasi disertai brosur pencegahan jatuh pada pasien / keluarga</td>
        <td class="center">{!! $data->int_a2 == 1 ? '<span class="chk">&#10003;</span>' : '' !!}</td>
        <td class="center">{!! (($data->int_a2 === 0 || $data->int_a2 === '0') && $data->int_a2 !== null) ? '<span class="chk">&#10003;</span>' : '' !!}</td>
    </tr>

    <tr>
        <td class="col-no center">3.</td>
        <td>Memastikan lingkungan yang aman dan nyaman:</td>
        <td class="center">{!! $data->int_a3 == 1 ? '<span class="chk">&#10003;</span>' : '' !!}</td>
        <td class="center">{!! (($data->int_a3 === 0 || $data->int_a3 === '0') && $data->int_a3 !== null) ? '<span class="chk">&#10003;</span>' : '' !!}</td>
    </tr>
    <tr><td></td><td class="sub-item"><span class="chk">&#9658;</span> Ruang rapi</td><td></td><td></td></tr>
    <tr><td></td><td class="sub-item"><span class="chk">&#9658;</span> Jalur pasien bebas obstruksi</td><td></td><td></td></tr>
    <tr><td></td><td class="sub-item"><span class="chk">&#9658;</span> Menunjukkan dan dekatkan bel pemanggil darurat dan benda pribadi seperti handphone dalam jangkauan</td><td></td><td></td></tr>
    <tr><td></td><td class="sub-item"><span class="chk">&#9658;</span> Posisikan tempat tidur rendah, roda terkunci dan kedua sisi pegangan tempat tidur terpasang dengan baik</td><td></td><td></td></tr>
    <tr><td></td><td class="sub-item"><span class="chk">&#9658;</span> Pastikan cahaya adekuat dan sesuai kebutuhan pasien</td><td></td><td></td></tr>
    <tr><td></td><td class="sub-item"><span class="chk">&#9658;</span> Menjaga lantai kamar mandi dengan karpet anti slip / tidak licin</td><td></td><td></td></tr>

    <tr>
        <td class="col-no center">4.</td>
        <td>Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam): jadwalkan ke belakang (kamar kecil) secara teratur</td>
        <td class="center">{!! $data->int_a4 == 1 ? '<span class="chk">&#10003;</span>' : '' !!}</td>
        <td class="center">{!! (($data->int_a4 === 0 || $data->int_a4 === '0') && $data->int_a4 !== null) ? '<span class="chk">&#10003;</span>' : '' !!}</td>
    </tr>

    {{-- ===== SEKSI B ===== --}}
    <tr>
        <td colspan="2" class="int-label">
            B. Intervensi Jatuh Risiko Tinggi: Skor <span class="chk">&#8805;</span> 4
        </td>
        <td class="ya-tidak" style="background:#d8d8d8;">YA</td>
        <td class="ya-tidak" style="background:#d8d8d8;">TIDAK</td>
    </tr>

    @php
    $intBItems = [
        1  => 'Melakukan intervensi jatuh risiko rendah',
        2  => 'Pakaikan gelang risiko jatuh warna kuning',
        3  => 'Pasang tanda risiko jatuh segitiga warna kuning pada bed pasien atau berikan tanda di depan kamar pasien untuk penanda pasien risiko jatuh',
        4  => 'Mengkomunikasikan risiko jatuh pasien pada anggota tim interdisiplin',
        5  => 'Dorong partisipasi keluarga dalam keselamatan pasien misalnya jangan tinggalkan pasien sendiri',
        6  => 'Menempatkan pasien di kamar yang dekat nurse station',
        7  => 'Melakukan kunjungan dan pengawasan ketat terhadap pasien (minimal 1 jam)',
        8  => 'Gunakan kaus kaki atau sepatu yang tidak licin dan siapkan alat bantu jalan yang sesuai misalnya walker untuk membantu stabilitas berjalan',
        9  => 'Konsul ke Farmasi Klinik unit kerja untuk kemungkinan interaksi obat dan Rehabilitasi Medik untuk masalah mobilitas / aktivitas harian / ADL baru',
        10 => 'Gunakan aktivitas pengalihan untuk mencegah pasien keluyuran',
        11 => 'Komunikasikan risiko pasien jatuh pada saat laporan antar shift',
    ];
    @endphp

    @foreach($intBItems as $no => $label)
    <tr>
        <td class="col-no center">{{ $no }}.</td>
        <td>{{ $label }}</td>
        <td class="center">{!! ($data->{'int_b'.$no} ?? null) == 1 ? '<span class="chk">&#10003;</span>' : '' !!}</td>
        <td class="center">{!! (($data->{'int_b'.$no} ?? null) === 0 || ($data->{'int_b'.$no} ?? null) === '0') && ($data->{'int_b'.$no} ?? null) !== null ? '<span class="chk">&#10003;</span>' : '' !!}</td>
    </tr>
    @endforeach

    {{-- Keterangan bawah --}}
    <tr>
        <td colspan="4" style="font-size:7.5pt; padding:4px 6px;">
            <strong>KETERANGAN:</strong> Beri tanda (<span class="chk">&#10003;</span>) pada kolom YA untuk pelaksanaan pencegahan
        </td>
    </tr>
</table>

{{-- Nama Petugas & Paraf --}}
<table class="ttd-table" style="margin-top:10px;">
    <tr>
        <td style="width:70%; vertical-align:middle; text-align:left; padding:4px 6px; font-size:8.5pt;">
            <strong>Nama petugas dan paraf :</strong>
            <span style="display:inline-block; min-width:180px; border-bottom:1px solid #000; padding:0 4px;">
                {{ $data->nama_petugas ?? '' }}
            </span>
        </td>
        <td style="width:30%; vertical-align:bottom; text-align:center; padding:4px;">
            @if(!empty($data->ttd_petugas))
                <img src="{{ $data->ttd_petugas }}" class="ttd-img"/>
            @else
                <div style="height:50px;"></div>
            @endif
            @if(!empty($data->ttd_petugas_timestamp))
                <div style="font-size:7pt; color:#555;">{{ $data->ttd_petugas_timestamp }}</div>
            @endif
            <div class="ttd-line">{{ $data->nama_petugas ?? '(Petugas)' }}</div>
        </td>
    </tr>
</table>

</body>
</html>
