<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Resume Medis Rawat Jalan</title>
    <style>
        @page { margin: 13px; }
        body { margin: 13px; }
        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }
    </style>
</head>
<body>

<div style="position:fixed; right: 13px; bottom: 10px;"></div>

<?php $fullpath = storage_path('app/public/header.png'); ?>

<div class="wrap">
    <table style="width: 100%; text-align: center" border="0">
        <thead>
            <tr>
                <th>
                    <img
                        style="width: 100px; position: relative; left: -300px;"
                        src="data:image/png;base64,{{ base64_encode(file_get_contents($fullpath)) }}"
                    />
                    <p style="margin-top: -85px; margin-left: -260px">
                        <span style="font-size: 14px;">RUMAH SAKIT KHUSUS MATA</span><br />
                        <span style="font-size: 35px; color: #18365d">PRIMA VISION</span><br />
                        <span style="font-size: 14px;">VISION FOR THE NATION</span>
                    </p>
                </th>
            </tr>
        </thead>
    </table>

    <div style="width: 100%; height: 1px; background: #353535;"></div>

    {{-- IDENTITAS --}}
    <table style="width: 100%; margin-top: 10px">
        <tr>
            <td style="width: 50%">
                <table style="width: 100%">
                    <tr><td>Nama Lengkap</td><td>: {{ $data['nama'] ?? '' }}</td></tr>
                    <tr><td>No. Rekam Medis</td><td>: {{ $data['no_rm'] ?? '' }}</td></tr>
                    <tr><td>NIK</td><td>: {{ $data['nik'] ?? '' }}</td></tr>
                    <tr>
                        <td>Tanggal Berobat</td>
                        <td>:
                            {{ !empty($data['tanggal_berobat'])
                                ? \Carbon\Carbon::parse($data['tanggal_berobat'])->format('d/m/Y')
                                : '' }}
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%">
                <table style="width: 100%">
                    <tr><td>Dokter</td><td>: {{ $data['dokter'] ?? '' }}</td></tr>
                    <tr><td>Poli</td><td>: {{ $data['poli'] ?? '' }}</td></tr>
                    <tr><td>Penanggung</td><td>: {{ $data['penanggung'] ?? '' }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- RESUME --}}
    <table style="width: 100%; margin-top: 20px" border="1" cellpadding="5">
        <thead>
            <tr>
                <th colspan="2">RESUME MEDIS RAWAT JALAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="40%">Anamnese</td>
                <td>{!! nl2br(e($data['anamnese'] ?? '')) !!}</td>
            </tr>
            <tr>
                <td>Pemeriksaan Fisik</td>
                <td>{!! nl2br(e($data['pemeriksaan_fisik'] ?? '')) !!}</td>
            </tr>
            <tr>
                <td>Alergi Obat</td>
                <td>{!! nl2br(e($data['alergi_obat'] ?? '')) !!}</td>
            </tr>
            <tr>
                <td>Penunjang Medis</td>
                <td>{!! nl2br(e($data['penunjang_medis'] ?? '')) !!}</td>
            </tr>
            <tr>
                <td>Diagnosa</td>
                <td>{!! nl2br(e($data['diagnosa'] ?? '')) !!}</td>
            </tr>
            <tr>
                <td>Terapi / Tindakan</td>
                <td>
                    {!! nl2br(e($data['tindakan'] ?? '')) !!}
                    <br>
                    {!! nl2br(e($data['terapi'] ?? '')) !!}
                </td>
            </tr>
            <tr>
                <td>Riwayat</td>
                <td>{!! nl2br(e($data['riwayat'] ?? '')) !!}</td>
            </tr>
            <tr>
                <td>Edukasi</td>
                <td>{!! nl2br(e($data['edukasi'] ?? '')) !!}</td>
            </tr>
            <tr>
                <td>Kontrol</td>
                <td>
                    {{ !empty($data['tanggal_kontrol'])
                        ? \Carbon\Carbon::parse($data['tanggal_kontrol'])->format('d/m/Y')
                        : '' }}
                    {{ $data['tempat_kontrol'] ?? '' }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- TTD --}}
    <table style="width: 100%; margin-top: 40px; text-align: center">
        <tr>
            <td>{{ date('d/m/Y H:i') }} WIB</td>
        </tr>
        <tr>
            <td>Dokter Yang Memeriksa</td>
        </tr>
        <tr>
            <td style="height: 80px">
                @if(!empty($data['ttd_dokter']))
                    <img src="{{ $data['ttd_dokter'] }}" style="width:150px">
                @endif
            </td>
        </tr>
        <tr>
            <td>{{ $data['nama_dokter'] ?? '' }}</td>
        </tr>
    </table>
</div>

</body>
</html>
