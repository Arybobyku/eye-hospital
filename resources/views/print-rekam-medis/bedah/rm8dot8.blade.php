<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM8.8</title>
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
            margin-left: -50px;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 8.8/LIAV/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div>
        <H4 style="text-align: center;"> <u>LAPORAN INJEKSI ANTI VEGA </u></H4>
            <p style="text-align: right;  margin-bottom: 5%;"> Tgl. Operasi :.................................</p>
            <table class="tablee" style="width: 100%">
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
                        <li style="Margin-bottom: 10px">Pasien berbaring dalam anestesi topical/ local/ umum.</li>
                        <li style="Margin-bottom: 10px">Dilakukan tindakan a & antiseptis menggunakan providone iodin.</li>
                        <li style="Margin-bottom: 10px">Dipasangkan eye drape.</li>
                        <li style="Margin-bottom: 10px">Dipasangkan blefarostat.</li>
                        <li style="Margin-bottom: 10px">Dilakukan pengukuran menggunakan caliper/trocar dengan jarak 3,5/4mm dari limbus di kuadran superior/temporal.</li>
                        <li style="Margin-bottom: 10px">Dilakukan injeksi avasin / intravitreal sebanyak ........... ml.</li>
                        <li style="Margin-bottom: 10px">Diteteskan antibiotik.</li>
                        <li style="Margin-bottom: 10px">Mata ditutup kasa & dop.</li>
                        <li style="Margin-bottom: 10px">Tindakan selesai</li>
                    </ol>
            </table>
            <table style="width: 100%; text-align:right;  padding-top: 1%; padding-bottom: 3%; padding-right: 10%">
                <tr>
                    <td> Tanda Tangan DPJP/Dokter</td>
                </tr> <br><br><br>
                <tr>
                    <td> (.........................................)</td>
                </tr>
            </table>
    </div>