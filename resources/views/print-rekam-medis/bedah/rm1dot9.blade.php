<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.9</title>
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
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }

        .tablee2 {
            border-top: 1px solid black;
            border-collapse: collapse;

        }

        .td1 {
            border-right: 1px solid black;
            border-collapse: collapse;
        }

        .td2 {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .td3 {
            width: 30%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .smallfont {
            font-size: 11;
        }

        .logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 100px;
            /* Ubah ukuran sesuai kebutuhan Anda */
        }
    </style>

<body>

    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 1.9/SM(PO)/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div class="smallfont">
        <table class="tablee" style="width: 100%; text-align: center;">
            <tr>
                <td style="text-align: center" colspan="4"><b>SITE MARKING (PENANDAAN OPERASI)</b></td>
            </tr>
        </table>
        <table class="tablee" style="width: 100%">
            <div style="text-align: center"> Beri tanda <b>Ya</b>(&#10004;) pada lokasi yang akan dioperasi menggunakan
                alat
                penanda atau <i>marker</i></td>
            </div>
            <br>
            <table  style="width: 50%; text-align:center; margin-left:25%">
                <tr>
                    <td class="td2" style="text-align: right"> <input type="checkbox" checked></td>
                    <td class="td2" style="text-align: left">MATA KANAN (OD)</td>

                    <td class="td2" style="text-align: right"> <input type="checkbox" checked></td>
                    <td class="td2" style="text-align: left">MATA KIRIa (OS)</td>
                </tr>
            </table>

            <table style="width: 50%; text-align:center; margin-left:25%">
                <tr style="text-align: center">

                    <td class="td2"><img src="images/header.png" alt="Logo" class="logo"></td>
                    <td class="td2"><img src="images/header.png" alt="Logo" class="logo"></td>

                </tr> <br>
                <tr>
                    <td colspan="4" style="align-text:canter;"> Tanggal :..................... Jam
                        :.....................
                    </td>
                </tr>
            </table>
            <table class="tablee2" style="width: 100%;">
                <tr>
                    <td class="td1">Tanda tangan Pasien/</td>
                    <td class="td1">Tanda tangan Dokter</td>
                    <td>Tanda tangan perawat</td>
                </tr>
                <tr>
                    <td class="td1">Keluarga</td>
                    <td class="td1">Yang merawat</td>
                    <td>Penanggung Jawab</td>
                </tr>
                <tr>
                    <td class="td1">(...................................)</td>
                    <td class="td1">(...................................)</td>
                    <td>(...................................)</td>
                </tr>
                <tr>
                    <td class="td1">Nama dan Tanda tangan</td>
                    <td class="td1">Nama dan Tanda tangan</td>
                    <td>Nama dan Tanda tangan</td>
                </tr>
            </table>
        </table>
    </div>
</body>