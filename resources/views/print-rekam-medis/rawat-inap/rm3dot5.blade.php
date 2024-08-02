<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM2.6</title>
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

        .sizesmall {
            font-size: 11;
        }

        .page_break {
            page-break-before: always;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 3.5/RM/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div class="warp">
        <table class="tablee2" style="width: 100%; text-align: center;">
            <tr>
                <td style="text-align: center" colspan="4"><b>RESUME MEDIS</b></td>
            </tr>
        </table>
        <table class="tablee" style="width: 100%">
            <tr>
                <td>Tanggal Masuk :</td>
                <td>Tanggal Keluar :</td>
            </tr>
            <tr>
                <td>Ruang Rawat Terakhir:</td>
                <td>Penanggung Pembayaran:</td>
            </tr>
        </table>
    </div>
</body>