<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REKAM MEDIS GENERAL - LAPORAN OPERASI PTERYGIUM</title>
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
            RM 9.0/LOP/22
        </div>
        @include('print-rekam-medis.partials.header')
        <h3 style="text-align: center">LAPORAN OPERASI PTERYGIUM</h3>        
        <table class="tablee" style="width: 100%;">
        <p style="text-align: right; padding-bottom: 4%; padding-right: 25%;"> Tgl. Operasi :</p>                    
            <table class="tablee" style="width:98%; position:relative; margin: 0 auto; ">
                <tr >
                    <td class="tablee">
                        <table>
                            <tr>
                                <td>Mata :</td>
                                <td>OD</td>
                                <td><input type="checkbox"> </td>
                                <td>OS</td>
                                <td><input type="checkbox"> </td>
                            </tr>
                        </table>
                    </td>
                    <td  style="padding-left: 5px; padding-bottom: 2%;" class="tablee"> Operator :</td>
                    <td  style="padding-left: 5px; padding-bottom: 2%;" class="tablee"> Jam Operasi : </td>
                    <td  style="padding-left: 5px; padding-bottom: 2%;" class="tablee"> Lama Operasi :</td>
                </tr>
                <tr>
                    <td  style="padding-left: 5px; padding-bottom: 2%;" class="tablee" colspan="2">Diagnosis : </td>
                    <td style="padding-left: 5px; padding-bottom: 2%;"  class="tablee" colspan="2">Asisten : </td>
                </tr>
                <tr>
                    <td style="padding-left: 5px; padding-bottom: 2%;"  class="tablee" colspan ="2">Anesthesia :</td>
                    <td style="padding-left: 5px; padding-bottom: 2%;" class="tablee">Jenis Operasi :</td>
                    <td style="padding-left: 5px; padding-bottom: 2%;"  class="tablee">Anesthesiologist :</td>
                </tr>
            </table>
            <table>
                <ol>
                    <ol style="padding-top: 2%;">
                        <li style="Margin-bottom: 10px">Pasien dalam posisi SUPINE di tempat tidur dan Anastesi Parabulper.</li>
                        <li style="Margin-bottom: 10px">Teknik A & Antiseptic.</li>
                        <li style="Margin-bottom: 10px">Tutup duklubang steril.</li>
                        <li style="Margin-bottom: 10px">Pasang Blefarostat.</li>
                        <li style="Margin-bottom: 10px">Injeksi Lidocain pada caput dan corpus pterygium.</li>
                        <li style="Margin-bottom: 10px">Pisahkan dari epitrkornea hingga bersih.</li>
                        <li style="Margin-bottom: 10px">Atasi pendarahan.</li>
                        <li style="Margin-bottom: 10px">Gunting corpus pterygium.</li>
                        <li style="Margin-bottom: 10px">Buat graft dari Konjungtiva bagian sup or</li>
                        <li style="Margin-bottom: 10px">Geser ke medial, jahit tepinya</li>
                        <li style="Margin-bottom: 10px">Salep antibiotik </li>
                        <li style="Margin-bottom: 10px">Operasi selesai</li>
                    </ol>
                    
            </table>
            <table style="width: 100%; text-align:center;  padding-top: 5%; padding-bottom: 3%; padding-right: 10%">
                            <tr>
                                <td style="padding-bottom: 80px;">Perawat</td>
                                <td style="padding-bottom: 80px;">Operator</td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 30px;">(...............................................)</td>
                                <td style="padding-bottom: 30px;">(...............................................)</td>
                            </tr>
                        </table>
        </table>
                    </td>
                </tr>
            </tr>