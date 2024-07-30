<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM3.3</title>
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

        .tablee3 {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 3.3/AG/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div class="wrap">
        <table class="tablee2" style="width: 100%; text-align: center;">
            <tr>
                <td style="text-align: center"><b>ASUHAN GIZI</b></td>
            </tr>
        </table>
    </div>
    <table class="tablee" style="width: 100%">
        <tr>
            <td colspan="2" style="padding-left: 5px; padding-bottom:40px">Diagnose Medis:</td>
        </tr>
        <tr>
            <td class="tablee3" colspan="2" style="text-align: center"><b>ASESMEN/PENGKAJIAN GIZI</b></td>
        </tr>
        <tr>
            <td colspan="2" style="padding-bottom: 20px; padding-left:5px"><b>Antropometri</b></td>
        </tr>
        <tr>
            <td style="padding-left: 5px">BB:_____________Kg</td>
            <td>IMT:____________Kg/m&#178;</td>
        </tr>
        <tr>
            <td style="padding-left: 5px; padding-bottom: 5px;">TB:_____________Kg</td>
            <td style="padding-bottom: 5px;">Tinggi Lutut:____________cm</td>
        </tr>
        <tr>
            <td class="tablee3" colspan="2" style="padding-bottom: 20px; padding-left:5px;"><b>Biokimia</b></td>
        </tr>
        <tr>
            <td class="tablee3" colspan="2" style="padding-bottom: 20px; padding-left:5px;"><b>Klinik/Fisik</b></td>
        </tr>
        <tr>
            <td class="tablee2" colspan="2" style="padding-bottom: 20px; padding-left:5px;"><b>Riwayat Gizi</b></td>
        </tr>
        <tr>
            <td style="padding-left:5px" colspan="2">Pola Makan :</td>
        </tr>
        <tr>
            <td style="padding-left:5px" colspan="2">Asupan Gizi :</td>
        </tr>
        <tr>
            <td class="tablee3" style="padding-left:5px" colspan="2"><b>Riwayat Personal</b></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td class="tablee3" colspan="2" style="text-align: center"><b>ASESMEN/PENGKAJIAN GIZI</b></td>
        </tr>
        <tr>
            <td class="tablee3" colspan="2" >&nbsp; <br>&nbsp;</td>
        </tr>
        <tr>
            <td class="tablee3" colspan="2" style="text-align: center"><b>INTERVENSI GIZI</b></td>
        </tr>
        <tr>
            <td class="tablee3" colspan="2" >&nbsp; <br>&nbsp;</td>
        </tr>
        <tr>
            <td class="tablee3" colspan="2" style="text-align: center"><b>RENCANA MONITORING DAN EVALUASI</b></td>
        </tr>
        <tr>
            <td style="text-align: right; padding-top:40px;" colspan="2">Tgl:........................Jam:........................WIB</td>
        </tr>
        <tr>
            <td style="text-align: right; Padding-right:110px;" colspan="2"><b>Ahli Gizi,</b></td>
        </tr>
        <tr>
            <td style="text-align: right; padding-top:30px;" colspan="2">......................................................................</td>
        </tr>
        <tr>
        <td style="text-align: right; Padding-right:80px;" colspan="2"><i>Nama & Tanda Tangan</i></td>
        </tr>
    </table>
</body>