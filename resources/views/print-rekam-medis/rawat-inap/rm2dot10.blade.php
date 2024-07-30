<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM2.10</title>
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
            width: 2%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td2 {
            width: 18%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td3 {
            width: 30%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td4 {
            width: 20%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td5 {
            width: 30%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .tablee2 {
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;

        }

        .sizesmall {
            font-size: 8;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 2.10/CPPTRI
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div class="wrap">
        <table class="tablee2" style="width: 100%; text-align: center;">
            <tr>
                <td style="text-align: center"><b>CATATAN PERKEMBANGAN PASIEN TERINTEGRASI RAWAT INAP</b></td>
            </tr>
        </table>
        <div class="sizesmall">
            <table class="tablee">
                <tr>
                    <th class="td1">TANGGAL/JAM</th>
                    <th class="td2" style="border-left:1px solid black;">PROFESI PEMBERIAN ASUHAN</th>
                    <th class="td3" style="border-left:1px solid black;">HASIL ASESMEN PASIEN DAN PEMBERIAN PELAYANAN
                        (Tuliskan dengan format SOAP/ADIME, disertai sasran, Tulis nama,beri paraf pada akhir catatan)
                    </th>
                    <th class="td4" style="border-left:1px solid black;">Intruksi PPA termasuk Pasca Bedah/Prosedur
                        (Insturksi ditulis dengan rinci dan jelas)</th>
                    <th class="td5" style="border-left:1px solid black;">PRIVIEW DAN VERIFIKASI DPJP(tulis nama,beri
                        paraf, tgl,jam)(DPJP harus membaca/mereview seluruh rencana asuhan)</th>
                </tr>
                <tr>
                    <th class="td1" style="border-top:1px solid black;">&nbsp;</th>
                    <th class="td2" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                    <th class="td3" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                    <th class="td4" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                    <th class="td5" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                </tr>
                <tr>
                    <th class="td1" style="border-top:1px solid black;">&nbsp;</th>
                    <th class="td2" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                    <th class="td3" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                    <th class="td4" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                    <th class="td5" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                </tr>
                <tr>
                    <th class="td1" style="border-top:1px solid black;">&nbsp;</th>
                    <th class="td2" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                    <th class="td3" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                    <th class="td4" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                    <th class="td5" style="border-left:1px solid black; border-top:1px solid black;">&nbsp;</th>
                </tr>

            </table>
        </div>
    </div>
</body>