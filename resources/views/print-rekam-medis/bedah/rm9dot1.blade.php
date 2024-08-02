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
        .tablee8dot8 {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .td18dot8 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 25%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td28dot8 {
            width: 7%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td38dot8 {
            width: 3%;
            padding-left: -10px;
            padding-right: -10px;
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
        <p style="text-align: right;  margin-bottom: 5%;"> Tgl. Operasi :.................................</p>
            <table class="tablee8dot8" style="width: 100%">
                <tr>
                    <td class="td28dot8">
                        Mata :
                    </td>
                    <td class="td38dot8">OD</td>
                    <td class="td38dot8"><input type="checkbox"></td>
                    <td class="td38dot8">OS</td>
                    <td class="td38dot8"><input type="checkbox"></td>
                    <td class="td18dot8">
                        Operator :
                    </td>
                    <td class="td18dot8">
                        Jam operasi :
                    </td>
                    <td class="td18dot8">
                        Lama Operasi :
                    </td>
                </tr>
                <tr>
                    <td class="td18dot8" colspan="6">
                        Diagnosis :
                    </td>
                    <td class="td18dot8" colspan="2">
                        Asisten:
                    </td>
                </tr>
                <tr>
                    <td class="td18dot8" colspan="5">
                        Jenis Operasi :
                    </td>
                    <td class="td18dot8" colspan="2">
                        Anesteshia :
                    </td>
                    <td class="td18dot8">
                        Anesthesiologist :
                    </td>
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