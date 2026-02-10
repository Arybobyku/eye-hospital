<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REKAM MEDIS GENERAL - SURAT KONSUL</title>
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

        table {
    page-break-inside: auto;
}

tr, td {
    page-break-inside: avoid;
}

        .left {
            display: inline-block;
            float: left;
        }

        .right {
            display: inline-block;
            float: right;
        }

        .img-wrapper {
            position: relative;
            display: inline-block;
            text-align: center;
        }

        .img-wrapper img {
            display: block;
            max-width: 100%;
            height: auto;
        }


        .text-above {
            text-align: center;
            margin-bottom: 5px;
        }

        .eye-print-item {
            display: inline-block;
            width: 45%;
            text-align: center;
            vertical-align: top;
        }

        .eye-print-item img {
            width: 220px;
            height: auto;
            border: 1px solid #ccc;
        }


        .eye-print-wrapper {
            width: 100%;
            margin-top: 40px;
            text-align: center;
        }

        .eye-print-single {
            display: inline-block;
        }

        .eye-label {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 12pt;
        }

        .eye-print-canvas {
            position: relative;
            width: 500px;     /* HARUS sama seperti di Vue */
            height: 250px;
            border: 1px solid #ccc;
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
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 8.7/FTLP/22
        </div>
        @include('print-rekam-medis.partials.header')
        <div style="margin-top:15px; font-weight:bold; text-align:center">
    FORM TINDAKAN LASER PRP
</div>
        <div class="">
            <table width="100%" style="margin-top:10px">
    <tr>
        <td></td>
        <td style="text-align:right">
            Tanggal: {{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
        </td>
    </tr>
</table>
        </div>

        <br>

        <table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
                    Diagnosa: {{ $data->diagnosa }}<br>
            </tr>
            <br>
            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
                    Langkah-langkah Tindakan Laser PRP :
                    <br>
                    <br>
                     1. Pasien diberi obat tetes pelebar pupil mata (Mydriatyl 1%) <br>
                    2. Perawat mempersiapkan berkas kelengkapan tindakan laser <br>
                    3. Perawat mengecek pupil mata pasien, jika pupil mata sudah lebar pasien masuk ke ruangan laser
                    <br>
                    4. Pasien diberi obat tetes Anestesi (Pantocain 0,5%) <br>
                    5. Pasien duduk menghadap ke alat laser <br>
                    6. Pasien menempelkan dagu dan dahi ke peyangga pada alat laser <br>
                    7. Dokter menyalakan alat Laser Photocoagulation <br>
                    8. Pasien dipasang Lensa Super Quad/Trans Equator pada mata yang akan dilaser <br>
                    9. Dilakukan tindakan laser dengan parameter laser : <br>
                    {{ $data->parameter_laser }}. <br>
                    10. Setelah selesai tindakan laser, pasien diberi obat tetes antibiotik <br>
                    11. Pasien diberikan resep obat dan surat kontrol

                    <br>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px">
                    @if($data->diagram_mata)
                    <div class="eye-print-wrapper">

                        <div class="eye-print-single">
                            <div class="eye-label">Diagram Tindakan Laser PRP</div>

                            <div class="eye-print-canvas">
                                {{-- BACKGROUND SVG --}}
                                <img
                                    src="{{ public_path('images/eye-prp-background.svg') }}"
                                    class="eye-bg"
                                >

                                {{-- CORETAAN DOKTER --}}
                                <img
                                    src="{{ $data->diagram_mata }}"
                                    class="eye-draw"
                                >
                            </div>
                        </div>

                    </div>
                    @endif
                </td>
            </tr>
            <br>
            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px">





                    {{-- <div class="img-wrapper" style="margin-top: 50px">
                        <div class="text-above">Mata Kiri</div>
                        <img style="width: 80%" src="\eye-hospital\storage\app\public\images\mataformlaserbarrage.png">
                    </div>

                    <div class="img-wrapper" style="margin-left: 85px">
                        <div class="text-above">Mata Kanan</div>
                        <img style="width: 80%" src="\eye-hospital\storage\app\public\images\mataformlaserbarrage.png">
                    </div>
                    <br> --}}

                    <div class="right">Tanda Tangan DPJP / Dokter

                        <div style="margin-left:20px">
                            <img src="{{ $data->ttd_dokter }}" alt="Base64 Image" width="200px">

                            <p>
                                {{ $data->nama_dokter }}
                            </p>
                        </div>
                    </div>




            </tr>

        </table>
    </div>
</body>

</html>


