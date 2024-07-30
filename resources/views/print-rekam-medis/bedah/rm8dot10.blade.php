<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM8.10</title>
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
            RM 8.10/LOT/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div>
        <H4 style="text-align: center; padding-top: 1%; padding-bottom: 1%;">LAPORAN OPERASI TRABEKULEKTOMI</H4>
        <table class="tablee" style="width: 100%;">
            <p style="text-align: right; padding-bottom: 4%;"> Tgl. Operasi
                :.................................</p>
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
                    <ol class="steps" style="padding-top: 1%;">
                        <li style="Margin-bottom: 10px">Pasien dalam posisi SUPINE di tempat tidur.</li>
                        <li style="Margin-bottom: 10px">Teknik A & Antiseptic.</li>
                        <li style="Margin-bottom: 10px">Pasang drape dan spekulum.</li>
                        <li style="Margin-bottom: 10px">Dilakukan Anasteshi Subkonjungtiva.</li>
                        <li style="Margin-bottom: 10px">Pemasangan kendali dengan benang slik 7-0 jahitan half thickness.</li>
                        <li style="Margin-bottom: 10px">Peritomi Konjungtiva superior dan cauter pendarahan.</li>
                        <li style="Margin-bottom: 10px">Buat insisi sk;era ukuran 4x3mm dan dibuat Flap Sklera.</li>
                        <li style="Margin-bottom: 10px">Dilakukan parasintesi dengan stab knife 15&deg; dan trabekulektomi ukuran 2x2mm.</li>
                        <li style="Margin-bottom: 10px">Lalu dilakukan iridektomi kemudian flab ditutup dan sklera dijahit tiap sudut dengan ethylon 10-0.</li>
                        <li style="Margin-bottom: 10px">Konjungtiva dijahit dengan benang ethylon 10-0</li>
                        <li style="Margin-bottom: 10px">Injeksi Antibiotik Gentamycin, Dexametason dan salep mata</li>
                        <li style="Margin-bottom: 10px">Operasi selesai</li>
                    </ol>
            </table>
            <table style="width: 100%; text-align:center;  padding-top: 10%; padding-bottom: 10%; padding-right: 10%">
                <tr>
                    <td>Perawat</td>
                    <td> Operator</td>
                </tr> <br><br><br>
                <tr>
                    <td> (..........................................................)</td>
                    <td> (..........................................................)</td>
                </tr>
            </table>
        </table>
    </div>