<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FORMULIR PULANG ATAS PERMINTAAN SENDIRI</title>
    <style>
    @page { margin: 18px; }
    body { 
        margin: 12px; 
        font-family: Arial, sans-serif;
        font-size: 9pt;
    }
    .wrap {
        width: 100%;
        height: auto;
    }
    .info-row {
        margin-bottom: 5px;
    }
    .info-row table {
        width: 90%;
        border-collapse: collapse;
    }
    .info-row td {
        padding: 2px 0;
    }
    .info-label {
        width: 200px;
    }
    .info-colon {
        width: 10px;
        text-align: center;
    }
    .info-value {
        border-bottom: 1px dotted #000;
        min-height: 20px;
        padding-left: 5px;
    }
    .consent-text {
        text-align: justify;
        line-height: 1.6;
        margin: 10px 0;
    }
    ol {
        margin-left: 20px;
        line-height: 1.6;
    }
    ol li {
        margin-bottom: 5px;
    }
    .signature-section {
        width: 100%;
        margin-top: 30px;
    }
    .signature-section table {
        width: 100%;
        border-collapse: collapse;
    }
    .signature-box {
        text-align: center;
        vertical-align: top;
        width: 50%;
        padding: 10px;
    }
    .signature-image {
        max-width: 200px;
        max-height: 100px;
        margin: 10px auto;
        display: block;
    }
    .signature-name {
        margin-top: 10px;
        font-size: 11pt;
    }
    .signature-label {
        font-size: 10pt;
        margin-top: 5px;
        color: #666;
    }
    </style>
</head>
<body>

<div class="wrap">
    <div style="width:100%; text-align:right; margin-bottom:5px; font-size:10pt;">
        {{ $formPulang->no_surat ?? 'RM 10.0/FPAPS/' . config('app.tahun_akreditasi', '22') }}
    </div>
    
    @include('print-rekam-medis.partials.header', [
    'fullpath' => public_path('images/header_rme.png')
])

    
    <br>
    
    <div style="font-weight: bold; text-align:center; font-size: 14pt; margin: 20px 0;"> 
        FORMULIR PULANG ATAS PERMINTAAN SENDIRI
    </div>
    
    <div style="margin-bottom: 15px;">
        <strong>Yang Bertanda tangan di bawah ini :</strong>
    </div>

    <!-- INFORMASI PASIEN -->
    <div class="info-row">
        <table>
            <tr>
                <td class="info-label">Nama Pasien</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ $formPulang->nama ?? '' }}</td>
            </tr>
        </table>
    </div>

    <div class="info-row">
        <table>
            <tr>
                <td class="info-label">NIK</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ $formPulang->nik ?? '' }}</td>
            </tr>
        </table>
    </div>

    <div class="info-row">
        <table>
            <tr>
                <td class="info-label">Jenis Kelamin</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ $formPulang->jenis_kelamin ?? '' }}</td>
            </tr>
        </table>
    </div>

    <div class="info-row">
        <table>
            <tr>
                <td class="info-label">Tempat/Tanggal Lahir</td>
                <td class="info-colon">:</td>
                <td class="info-value">
                    {{ $formPulang->tempat_lahir ?? '' }}@if($formPulang->tempat_lahir && $formPulang->formatted_tanggal_lahir), @endif{{ $formPulang->formatted_tanggal_lahir ?? '' }}
                </td>
            </tr>
        </table>
    </div>

    <div class="info-row">
        <table>
            <tr>
                <td class="info-label">Nomor Rekam Medis</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ $formPulang->no_rm ?? '' }}</td>
            </tr>
        </table>
    </div>

    <div class="info-row">
        <table>
            <tr>
                <td class="info-label">Agama</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ $formPulang->agama ?? '' }}</td>
            </tr>
        </table>
    </div>

    <div class="info-row">
        <table>
            <tr>
                <td class="info-label">Pekerjaan</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ $formPulang->pekerjaan ?? '' }}</td>
            </tr>
        </table>
    </div>

    <div class="info-row">
        <table>
            <tr>
                <td class="info-label" style="vertical-align: top;">Alamat</td>
                <td class="info-colon" style="vertical-align: top;">:</td>
                <td class="info-value">{{ $formPulang->alamat ?? '' }}</td>
            </tr>
        </table>
    </div>

    <br>

    <!-- PERNYATAAN -->
    <div class="consent-text">
        Dengan ini menyatakan permintaan untuk menghentikan perawatan/pengobatan dan meminta pulang atas kemauan sendiri atas alasan:
    </div>

    <div style="padding-left: 20px; font-style: italic; margin: 15px 0; line-height: 1.6;">
        {{ $formPulang->alasan ?? '..........................................................................................................' }}
    </div>

    <div class="consent-text">
        Sebagai pasien/keluarga pasien, saya telah mendapatkan penjelasan dari rumah sakit tentang:
    </div>

    <ol>
        <li>Hak saya menolak atau tidak melanjutkan pengobatan.</li>
        <li>Tentang konsekuensi dari Keputusan saya untuk pulang atas permintaan sendiri.</li>
        <li>Tentang tanggung jawab saya dengan Keputusan tersebut.</li>
        <li>Tersedianya alternatif pelayanan dan pengobatan untuk pengobatan lanjutan.</li>
    </ol>

    <div class="consent-text">
        Dan saya tidak akan menuntut pihak rumah sakit atau siapapun juga akibat dari Keputusan saya pulang atas permintaan sendiri.
    </div>

    <br>

    <!-- TANGGAL -->
    <div style="text-align: right; margin: 20px 50px 0 0;">
        Medan, {{ $formPulang->formatted_tanggal ?? '.....................................' }}
    </div>

    <!-- TANDA TANGAN -->
    <div class="signature-section">
        <table>
            <tr>
                <td class="signature-box">
                    <div style="font-weight: bold; margin-bottom: 10px;">Keluarga Pasien</div>
                    @if(!empty($formPulang->ttd_keluarga))
                        <img src="{{ $formPulang->ttd_keluarga }}" class="signature-image" alt="TTD Keluarga">
                    @else
                        <div style="height: 100px;"></div>
                    @endif
                    <div class="signature-name">
                        ( <u>{{ $formPulang->nama_keluarga_ttd ?? '..................................' }}</u> )
                    </div>
                </td>
                <td class="signature-box">
                    <div style="font-weight: bold; margin-bottom: 10px;">DPJP</div>
                    @if(!empty($formPulang->ttd_dpjp))
                        <img src="{{ $formPulang->ttd_dpjp }}" class="signature-image" alt="TTD DPJP">
                    @else
                        <div style="height: 100px;"></div>
                    @endif
                    <div class="signature-name">
                        ( <u>{{ $formPulang->nama_dpjp_ttd ?? '..................................' }}</u> )
                    </div>
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>