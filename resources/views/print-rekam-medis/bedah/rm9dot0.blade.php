<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM9.0</title>
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

        .td1 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 25%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td2 {
            width: 7%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td3 {
            width: 3%;
            padding-left: -10px;
            padding-right: -10px;
        }

        .steps {
            margin-left: -30px;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 9.0/LOP/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div>
        <H4 style="text-align: center;">LAPORAN OPERASI PTERYGIUM</H4>
        <table class="tablee" style="width: 100%;">
            <P style="Margin-bottom: 3px; Margin-left: 5px"> No. RM :</P>
            <P style="Margin-bottom: 5px; Margin-left: 5px">Nama :</P>
            <P style="Margin-bottom: 5px; Margin-left: 5px">Jenis Kelamin :</P>
            <P style="Margin-bottom: 5px; Margin-left: 5px">Tanggal lahir :</P>
            <p style="text-align: right; margin: 10px"> Tgl. Operasi :.................................</p>
            <table class="tablee" style="width: 100%; padding-left: 10px; padding-right: 10px;">
                <tr>
                    <td class="td2">
                        Mata :
                    </td>
                    <td class="td3">OD</td>
                    <td class="td3"><input type="checkbox"></td>
                    <td class="td3">OS</td>
                    <td class="td3"><input type="checkbox"></td>
                    <td class="td1">
                        Operator :
                    </td>
                    <td class="td1">
                        Jam operasi :
                    </td>
                    <td class="td1">
                        Lama Operasi :
                    </td>
                </tr>
                <tr>
                    <td class="td1" colspan="6">
                        Diagnosis :
                    </td>
                    <td class="td1" colspan="2">
                        Asisten:
                    </td>
                </tr>
                <tr>
                    <td class="td1" colspan="5">
                        Jenis Operasi :
                    </td>
                    <td class="td1" colspan="2">
                        Anesteshia :
                    </td>
                    <td class="td1">
                        Anesthesiologist :
                    </td>
                </tr>
            </table>
            <table>
                <ol>
                    <ol class="steps" style="padding-top: 3%;">
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
                        <li style="Margin-bottom: 10px">Salp</li>
                        <li style="Margin-bottom: 10px">Operasi selesai</li>
                    </ol>
            </table>
            <table style="width: 100%; text-align:center;  padding-top: 1%; padding-bottom: 3%; padding-right: 10%">
                <tr>
                    <td>Perawat</td>
                    <td> Operator</td>
                </tr> <br><br><br>
                <tr>
                    <td>(..........................................................)</td>
                    <td> (..........................................................)</td>
                </tr>
            </table>
        </table>
    </div>