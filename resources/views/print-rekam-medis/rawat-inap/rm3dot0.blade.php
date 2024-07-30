<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM3.0</title>
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

        .th1 {
            width: 25%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .th2 {
            width: 15%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .th3 {
            width: 50%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .th4 {
            width: 10%;
            padding-left: 5px;
            padding-right: 5px;
        }


        .tablee2 {
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;

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
            RM 3.0/CP/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div class="wrap">
        <table class="tablee2" style="width: 100%; text-align: center;">
            <tr>
                <td style="text-align: center"><b>CATATAN KEPERAWATAN</b></td>
            </tr>
        </table>
        <table class="tablee" style="width: 100%">
            <tr>
                <th class="th1" style="border-left:1px solid black;">TANGGAL</th>
                <th class="th2" style="border-left:1px solid black;">JAM</th>
                <th class="th3" style="border-left:1px solid black;">URAIAN</th>
                <th class="th4" style="border-left:1px solid black;">NAMA & PARAF</th>
            </tr>
            <tr>
                <th class="th1" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th2" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th3" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th4" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
            </tr>
            <tr>
                <th class="th1" style="border-top:1px solid black;">&nbsp;</th>
                <th class="th2" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th3" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th4" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
            </tr>
            <tr>
                <th class="th1" style="border-top:1px solid black;">&nbsp;</th>
                <th class="th2" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th3" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th4" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
            </tr>
        </table>
        <div class="page_break"></div>
        <table class="tablee" style="width: 100%">
            <tr>
                <th class="th1" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th2" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th3" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th4" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
            </tr>
            <tr>
                <th class="th1" style="border-top:1px solid black;">&nbsp;</th>
                <th class="th2" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th3" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th4" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
            </tr>
            <tr>
                <th class="th1" style="border-top:1px solid black;">&nbsp;</th>
                <th class="th2" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th3" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                <th class="th4" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
            </tr>
        </table>
    </div>
</body>