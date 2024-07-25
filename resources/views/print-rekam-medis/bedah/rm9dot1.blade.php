<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM9.1</title>
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

        .tablee9dot1 {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .td19dot1 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 25%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td29dot1 {
            width: 7%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td39dot1 {
            width: 3%;
            padding-left: -10px;
            padding-right: -10px;
        }

        .steps9dot1 {
            margin-left: -20px;
            margin-top: -10px;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 9.1/LIC/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div>
        <H4 style="text-align: center; padding-top: 1%; padding-bottom: 1%;">LAPORAN INSISI CHALAZION</H4>
        <table class="tablee9dot1" style="width: 100%;">
            <table style="padding-left :2%;">
                <tr>
                    <td>Diagnosis Pra Bedah</td>
                    <td> :</td>
                </tr>
                <tr>
                    <td>Tindakan</td>
                    <td> :</td>
                </tr>
                <tr>
                    <td>Diagnosis Post Bedah</td>
                    <td> :</td>
                </tr><br><br>
                <tr>
                    <td>Unit Pembedahan</td>
                    <td> :</td>
                </tr>
            </table>
            <table>
                <ol>
                    <ol class="steps9dot1">
                        <li style="Margin-bottom: 10px">Pasien dibaringkan di meja operasi.</li>
                        <li style="Margin-bottom: 10px">Disinfektan lapangan operasi dengan betadine.</li>
                        <li style="Margin-bottom: 10px">Tutup dengan doek steril.</li>
                        <li style="Margin-bottom: 10px">Pasang forceps chalizon.</li>
                        <li style="Margin-bottom: 10px">Anestesi dengan inj. Lidocain subconjungtiva margin palpebra.</li>
                        <li style="Margin-bottom: 10px">Incesi daerah chalizon, tampak keluar nanah.</li>
                        <li style="Margin-bottom: 10px">Bersihkan chalizon dengan cuvet.</li>
                        <li style="Margin-bottom: 10px">Kontrol perdaharahn.</li>
                        <li style="Margin-bottom: 10px">Beri salep antibiotik kemudian ditutup dengan kassa steril.</li>
                        <li style="Margin-bottom: 10px">Operasi selesai.</li>
                    </ol>
            </table>
            <p style="padding-left: 3%;">Terapi Pasca Bedah :</p>
            <table style="width: 100%; text-align:center;  padding-top: 10%; padding-bottom: 10%; padding-right: 10%">
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