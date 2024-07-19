<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM2.5</title>
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

        .tablee2 {
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;

        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 2.5/SPUDI/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div class="smallfont">
        <table class="tablee2" style="width: 100%; text-align: center;">
            <tr>
                <td style="text-align: center" colspan="4"><b>SURAT PENGANTAR UNTUK DIRAWAT INAP</b></td>
            </tr>
        </table>
        <table class="tablee" style="width: 100%">
            <table style="width: 100%;  margin:1px;">
                <tr>
                    <td style="height: 80px">Asal Ruangan</td>
                    <td> :</td>
                    <td><input type="checkbox"></td>
                    <td>IGD</td>
                    <td><input type="checkbox"></td>
                    <td>Poliklinik,........................................</td>
                </tr>
                <tr>
                    <td style="height: 80px">Rencana Perawatan di</td>
                    <td>:</td>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <td colspan="6" style="height: 30px">Bersama ini kami kirimkan pasien tersebut diatas untuk dirawat
                        inap:</td>
                </tr>
                <tr>
                    <td style="height: 80px">Karena Menderita</td>
                    <td>:</td>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <td style="height: 80px">Saran Terapi</td>
                    <td>:</td>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <td style="height: 80px">Rencana Tindakan</td>
                    <td>:</td>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <td colspan="6" style="height: 80px">Mohon ditindaklanjuti untuk rencana tindakan terapi.</td>
                </tr>
            </table>
            <table style="width: 100%; text-align:center">
                <tr>
                    <td style="height: 80px">Medan, Tgl..... Jam :........WIB</td>
                </tr>
                <tr>
                    <td style="padding-bottom: 100px">Dokter Yang memeriksan </td>
                </tr>
                <tr>
                    <td>(............................................................)</td>
                </tr>
                <tr>
                    <td>Nama Jelas dan Tanda Tangan</td>
                </tr>
            </table>
        </table>
    </div>