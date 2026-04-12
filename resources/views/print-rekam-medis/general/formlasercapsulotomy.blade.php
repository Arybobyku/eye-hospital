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
            {{ $data->no_surat ?? 'RM 8.9/FTL/' . config('app.tahun_akreditasi', '22') }}
        </div>
        @include('print-rekam-medis.partials.header')
        <br />

        <br>

        <div style="font-weight: bold; text-align:center">
            FORM TINDAKAN LASER CAPSULOTOMY (Nd. YAG)
        </div>
        <br>
        <div class="">
            <span class="right"> Tanggal:
                {{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }} </span>
        </div>

        <br>

        <table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
                    Diagnosa: {{ $data->diagnosa }} <br>
            </tr>

            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
                    Langkah-langkah Tindakan Laser Capsulotomy (Nd. YAG) :
                    <br>
                    <br>
                    1.Pasien diberi obat tetes pelebar pupil mata (Mydriatyl 1%) <br>
                    2.Perawat mempersiapkan berkas kelengkapan tindakan laser <br>
                    3.Perawat mengecek pupil mata pasien, jika pupil mata sudah lebar pasien masuk ke ruangan laser <br>
                    4.Pasien diberi obat tetes Anestesi (Pantocain 0,5%) <br>
                    5.Pasien duduk menghadap ke alat laser <br>
                    6.Pasien menempelkan dagu dan dahi ke peyangga pada alat laser <br>
                    7.Dokter menyalakan alat YAG Laser <br>
                    8.Dilakukan tindakan laser dengan Parameter (Power) Laser : <br>
                    {{ $data->parameter_laser }}. <br>
                    9. Setelah selesai tindakan laser, pasien diberi obat tetes antibiotik <br>
                    10. Pasien diberikan resep obat dan surat kontrol
                    <br>
                </td>
            </tr>

                    <!-- {{-- <table>
                        <tr>
                            <td>Mata :</td>
                            <td>OD</td>
                            <td>
                                <input type="checkbox" {{ $data->mata_od ? 'checked' : '' }}>
                            </td>
                            <td>OS</td>
                            <td>
                                <input type="checkbox" {{ $data->mata_os ? 'checked' : '' }}>
                            </td>
                        </tr>
                    </table> --}}

                    <br> -->
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
            <tr>

            <tr>
                    <br>

                    <div class="img-wrapper" style="margin-top: 50px">
                        <div class="text-above">Mata Kiri</div>
                        {{-- <img style="width: 80%" src="\eye-hospital\storage\app\public\images\mataformlaserbarrage.png"> --}}
                        <input type="checkbox" {{ $data->mata_od ? 'checked' : '' }}>
                    </div>

                    <div class="img-wrapper" style="margin-left: 85px">
                        <div class="text-above">Mata Kanan</div>
                        {{-- <img style="width: 80%" src="\eye-hospital\storage\app\public\images\mataformlaserbarrage.png"> --}}
                        <input type="checkbox" {{ $data->mata_os ? 'checked' : '' }}>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="right">Tanda Tangan DPJP / Dokter
                        <br>
                        <br>
                        <div style="margin-left:20px">
                            <img src="{{ $data->ttd_dokter }}" alt="Base64 Image" width="200px">

                            <br>
                            <br>
                            <center>
                                ( {{ $data->nama_dokter }})
                            </center>
                        </div>
                    </div>
            </tr>

        </table>
    </div>
</body>

</html>
















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
        <br />

        <br>

        <div style="font-weight: bold; text-align:center">
            FORM TINDAKAN LASER CAPSULOTOMY (Nd. YAG)
        </div>
        <br>
        <div class="">
            <span class="right"> Tanggal:
                {{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }} </span>
        </div>

        <br>

        <table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
                    Diagnosa: {{ $data->diagnosa }} <br>
            </tr>

            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
                    Langkah-langkah Tindakan Laser Capsulotomy (Nd. YAG) :
                    <br>
                    <br>
                    1.Pasien diberi obat tetes pelebar pupil mata (Mydriatyl 1%) <br>
                    2.Perawat mempersiapkan berkas kelengkapan tindakan laser <br>
                    3.Perawat mengecek pupil mata pasien, jika pupil mata sudah lebar pasien masuk ke ruangan laser <br>
                    4.Pasien diberi obat tetes Anestesi (Pantocain 0,5%) <br>
                    5.Pasien duduk menghadap ke alat laser <br>
                    6.Pasien menempelkan dagu dan dahi ke peyangga pada alat laser <br>
                    7.Dokter menyalakan alat YAG Laser <br>
                    8.Dilakukan tindakan laser dengan Parameter (Power) Laser : <br>
                    {{ $data->parameter_laser }}. <br>
                    9. Setelah selesai tindakan laser, pasien diberi obat tetes antibiotik <br>
                    10. Pasien diberikan resep obat dan surat kontrol
                    <br>
                </td>
            </tr>

                    <!-- {{-- <table>
                        <tr>
                            <td>Mata :</td>
                            <td>OD</td>
                            <td>
                                <input type="checkbox" {{ $data->mata_od ? 'checked' : '' }}>
                            </td>
                            <td>OS</td>
                            <td>
                                <input type="checkbox" {{ $data->mata_os ? 'checked' : '' }}>
                            </td>
                        </tr>
                    </table> --}}

                    <br> -->
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
            <tr>

            <tr>
                    <br>

                    <div class="img-wrapper" style="margin-top: 50px">
                        <div class="text-above">Mata Kiri</div>
                        {{-- <img style="width: 80%" src="\eye-hospital\storage\app\public\images\mataformlaserbarrage.png"> --}}
                        <input type="checkbox" {{ $data->mata_od ? 'checked' : '' }}>
                    </div>

                    <div class="img-wrapper" style="margin-left: 85px">
                        <div class="text-above">Mata Kanan</div>
                        {{-- <img style="width: 80%" src="\eye-hospital\storage\app\public\images\mataformlaserbarrage.png"> --}}
                        <input type="checkbox" {{ $data->mata_os ? 'checked' : '' }}>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="right">Tanda Tangan DPJP / Dokter
                        <br>
                        <br>
                        <div style="margin-left:20px">
                            <img src="{{ $data->ttd_dokter }}" alt="Base64 Image" width="200px">

                            <br>
                            <br>
                            <center>
                                ( {{ $data->nama_dokter }})
                            </center>
                        </div>
                    </div>
            </tr>

        </table>
    </div>
</body>

</html>
