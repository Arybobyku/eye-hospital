<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.3</title>
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

        .fontsmall {
            font-size: 10;
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

        .right {
            display: inline-block;
            float: right;
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
    <?php $patimg = storage_path('app/public/images/PAT.png'); ?>

    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            {{ $data->no_surat ?? 'RM 10.3/FTLPI/' . config('app.tahun_akreditasi', '22') }}
        </div>
        @include('print-rekam-medis.partials.header')

        <div style="font-weight: bold; text-align:center; margin-top:10px">
            FORM TINDAKAN LASER PERIPHERAL IRIDECTOMY (LPI)
        </div>
        <br>


        <div style="margin-top: 5px; float: right">
            <span> Tanggal :
                {{ \Carbon\Carbon::parse($data->tanggal_tindakan)->locale('id')->isoFormat('D MMMM YYYY') }} </span>
        </div>
        <br>
        <br>
        <table style="width: 100%; text-align: left; margin-top:5px; padding-top:10px" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px;   text-align: justify">
                    Diagnosa: {{ $data->diagnosa }}
                    <br>
                </td>
            </tr>
            <br>
            <tr>
               <td
                    style="width: 100%; font-size: 12pt;padding-top: 5px; line-height: 22px; padding-top: 5px; text-align: justify">
                    Langkah-langkah Tindakan Laser Peripheral Iridectomy (LPI) :
                    <br>
                    <br>
                    1.Pasien diberi obat tetes pengecil pupil mata carpin <br>
                    2.Perawat mempersiapkan berkas kelengkapan tindakan laser <br>
                    3.Perawat mengecek pupil mata pasien, jika pupil mata sudah kecil pasien masuk ke ruangan laser <br>
                    4.Pasien diberi obat tetes Anestesi (Pantocain 0,5%) <br>
                    5.Pasien duduk menghadap ke alat laser <br>
                    6.Pasien menempelkan dagu dan dahi ke peyangga pada alat laser <br>
                    7.Dokter menyalakan alat Laser Peripheral Iridectomy <br>
                    8.OVD/Viscuelastic diberikan pada lensa Ocular Abraham Iridectomy dan lensa dipasang pada <br>
                    mata yang akan dilaser <br>
                    9.Dilakukan tindakan Laser Peripheral Iridectomy (LPI) <br>

                    {{ $data->tindakan_laser_lpi }}. <br>

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
             <tr>
                    <br>

                    <div class="img-wrapper" style="margin-top: 50px">
                        <div class="text-above">Mata Kiri</div>
                        {{-- <img style="width: 80%" src="\eye-hospital\storage\app\public\images\mataformlaserbarrage.png"> --}}
                        <input type="checkbox" {{ $data->mata_kiri ? 'checked' : '' }}>
                    </div>

                    <div class="img-wrapper" style="margin-left: 85px">
                        <div class="text-above">Mata Kanan</div>
                        {{-- <img style="width: 80%" src="\eye-hospital\storage\app\public\images\mataformlaserbarrage.png"> --}}
                        <input type="checkbox" {{ $data->mata_kanan ? 'checked' : '' }}>
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

            <br>
            <br>

        </table>



</body>

</html>

