<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REKAM MEDIS GENERAL - LAPORAN OPERASI TREBEKULEKTOMI</title>
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
            RM 8.10/LOT/22
        </div>
        @include('print-rekam-medis.partials.header')
        <h3 style="text-align: center">LAPORAN OPERASI TRABEKULEKTOMI</h3>
        <table class="tablee" style="width: 100%;">
            <p style="text-align: right; padding-bottom: 4%; padding-right: 25%;"> Tgl. Operasi :
                {{ \Carbon\Carbon::parse($data->tanggal_operasi)->locale('id')->isoFormat('D MMMM YYYY') }}</p>
            <table class="tablee" style="width:98%; position:relative; margin: 0 auto; ">
                <tr>
                    <td class="tablee">
                        <table>
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
                        </table>
                    </td>
                    <td style="padding-left: 5px; padding-bottom: 3%;" class="tablee"> Operator : {{ $data->operator }}
                    </td>
                    <td style="padding-left: 5px; padding-bottom: 3%;" class="tablee"> Jam Operasi :
                        {{ $data->jam_operasi }}</td>
                    <td style="padding-left: 5px; padding-bottom: 3%;" class="tablee"> Lama Operasi :
                        {{ $data->lama_operasi }} </td>
                </tr>
                <tr>
                    <td style="padding-left: 5px; padding-bottom: 3%;" class="tablee" colspan="2">Diagnosis :
                        {{ $data->diagnosis }}</td>
                    <td style="padding-left: 5px; padding-bottom: 3%;" class="tablee" colspan="2">Asisten :
                        {{ $data->asisten }} </td>
                </tr>
                <tr>
                    <td style="padding-left: 5px; padding-bottom: 3%;" class="tablee" colspan ="2">Anesthesia :
                        {{ $data->anesthesia }}</td>
                    <td style="padding-left: 5px; padding-bottom: 3%;" class="tablee">Jenis Operasi :
                        {{ $data->jenis_operasi }}</td>
                    <td style="padding-left: 5px; padding-bottom: 3%;" class="tablee">Anesthesiologist :
                        {{ $data->anesthesiologist }}</td>
                </tr>
            </table>
            <table>
                <ol>
                    <ol style="padding-top: 3%;">
                        <li style="Margin-bottom: 10px">Pasien dalam posisi SUPINE di tempat tidur dan Anastesi
                            Parabulper.</li>
                        <li style="Margin-bottom: 10px">Teknik A & Antiseptic.</li>
                        <li style="Margin-bottom: 10px">Pasang drape dan spekulum .</li>
                        <li style="Margin-bottom: 10px">Dilakukan Anastesi Subkonjungtiva.</li>
                        <li style="Margin-bottom: 10px">Peritomi konjungtiva superior kemudian dibuat flap sclera.</li>
                        <li style="Margin-bottom: 10px">Buat Insisi berbentuk jendela antara Sclera dan Kornea.</li>
                        <li style="Margin-bottom: 10px">Setelah itu dilakukan Iridektomi, kemudian Flap Sclera dijahit
                            dan dilakukan penjahitan Konjungtiva </li>
                        <li style="Margin-bottom: 10px">Injeksi Antibiotik Gentamycin, Dexametason dan salep.</li>
                        <li style="Margin-bottom: 10px">Operasi selesai</li>
                    </ol>
            </table>
            <table style="width: 100%; text-align:center;  padding-top: 5%; padding-bottom: 3%; padding-right: 10%">
                <tr>
                    <td style="padding-bottom: 10px;">Perawat</td>
                    <td style="padding-bottom: 10px;">Operator</td>
                </tr>
                <tr>
                    <td>
                        <img src="{{ $data->ttd_perawat }}" alt="Base64 Image" width="200px">
                    </td>
                    <td>
                        <img src="{{ $data->ttd_operator }}" alt="Base64 Image" width="200px">
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom: 30px;">({{ $data->nama_perawat }})</td>
                    <td style="padding-bottom: 30px;">({{ $data->nama_operator }})</td>
                </tr>
            </table>
        </table>
        </td>
        </tr>
        </tr>
