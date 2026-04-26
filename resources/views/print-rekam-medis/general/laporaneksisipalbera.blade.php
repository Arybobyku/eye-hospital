<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REKAM MEDIS GENERAL - LAPORAN EKSISI PALPEBRA</title>
    <style>
        @page {
            margin: 18px;
        }

        body {
            margin: 18px;
        }

        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $eyero = storage_path('app/public/images/EYE-RO.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            {{ $data->no_surat ?? 'RM 9.3/LEP/' . config('app.tahun_akreditasi', '22') }}
        </div>
        @include('print-rekam-medis.partials.header')
        <h3 style="text-align: center">LAPORAN EKSISI PALPEBRA</h3>
        <table class="tablee" style="width:100%; position:relative">
            <tr>
                <td style="padding-bottom: 30px; padding-left: 8px;">Diagnosa Pra Bedah : {{ $data->diagnosa_pre_bedah }}
                </td>
            </tr>
            <tr>
                <td style="padding-bottom: 30px; padding-left: 8px;">Tindakan : {{ $data->tindakan }}</td>
            </tr>
            <tr>
                <td style="padding-bottom: 30px; padding-left: 8px;">Diagnosa Post Bedah:
                    {{ $data->diagnosa_post_bedah }}</td>
            </tr>
            <tr>
                <td style="padding-left: 8px;">Unit Pembedahan : {{ $data->unit_pembedahan }}</td>
            </tr>
            <tr>
                <td>
                    <ol style="line-height: 1.8;">
                        <li>Pasien dibaringkan di meja operasi.</li>
                        <li>Disinfektan lapangan operasi dengan betadine.</li>
                        <li>Tutup dengan doek steril.</li>
                        <li>Anestesi dengan inj. Lidocain subconjungtiva margin palpebra.</li>
                        <li>Incisi daerah tumor, eksplorasi tumor tampak masa diameter ±1 cm dengan konsistensi kenyal,
                            undermine subkutis.</li>
                        <li>Atasi perdarahan dengan kasa steril.</li>
                        <li>Lepaskan tumor dengan gunting.</li>
                        <li>Evaluasi area bebas tumor dan perdarahan.</li>
                        <li> Hecting subkutis dengan vicryl 6.0 3x, lanjutkan hecting kutis 5x</li>
                        <li> Beri Genta eye salep</li>
                        <li> Tutup kasa steril</li>
                        <li>Operasi selesai.</li>
                    </ol>
                </td>
            <tr>
                <td style="padding-bottom: 30px; padding-left: 8px;"> Terapi Pasca Bedah :
                    {{ $data->terapi_pasca_bedah }}</td>
            </tr>
            <tr>
                <td>
                    <table style="width:100%; text-align:center; margin-top:50px">
                        <tr>
                            <td style="padding-bottom: 10px;">Perawat</td>
                            <td style="padding-bottom: 10px;">Operator</td>
                        </tr>
                        <tr>
                            <td>
                                <img src="{{ $data->ttd_perawat }}" alt="Base64 Image" width="200px">
                            </td>
                            <td>
                                <img src="{{ $data->ttd_dokter }}" alt="Base64 Image" width="200px">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 30px;">({{ $data->nama_perawat }})</td>
                            <td style="padding-bottom: 30px;">({{ $data->nama_dokter }})</td>
                        </tr>
                    </table>
                </td>
            </tr>
            </tr>
    </div>
