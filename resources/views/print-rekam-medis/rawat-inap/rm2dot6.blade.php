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
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 2.6/TP/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div class="smallfont">
        <table class="tablee2" style="width: 100%; text-align: center;">
            <tr>
                <td style="text-align: center" colspan="4"><b>TRANSFER PASIEN</b></td>
            </tr>
        </table>
        <table class="tablee" style="width: 100%;">
            <tr>
                <td style="border-right: 1px solid black; ">Tanggal Masuk :</td>
                <td style="border-right: 1px solid black;">Tanggal Pindah :</td>
                <td style="border-right: 1px solid black;">Asal Ruangan:</td>
                <td>Ruangan Selanjutnya:</td>
            </tr>
            <tr>
                <td colspan="2" style="border-right: 1px solid black;  border-top: 1px solid black; ">Dokter Yang
                    Merawat :</td>
                <td colspan="2" style=" border-top: 1px solid black; "> Dokter Penanggung Jawab(DPJP):</td>
            </tr>
            <tr>
                <td colspan="2"style="border-right: 1px solid black; vertical-align: top; border-top: 1px solid black; ">Diagnosis
                    Utama:</td>
                <td colspan="2" style=" border-top: 1px solid black; ">Perlu menjadi perhatian :
                    <table>
                        <tr>
                            <td colspan="2"></td>
                            <td><input type="checkbox"></td>
                            <td>Alergi. Sebutkan...........</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td><input type="checkbox"></td>
                            <td>MRSA</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-right: 1px solid black; border-top: 1px solid black; ">Diagnosis Sekunder:</td>
                <td colspan="2" style="border-top: 1px solid black; ">Alasan Perpindahan Pasien :</td>
            </tr>
            <tr>
                <td colspan="2" style="border-right: 1px solid black;">1. </td>
                <td colspan="2">1. Kondisi Pasien: memburuk/stabil/<br>tidak ada perubuhan</td>
            </tr>
            <tr>
                <td colspan="2" style="border-right: 1px solid black;">2.</td>
                <td colspan="2">2. Fasilitas: Kurang memadai/<br>membutuhkan peralatan yang lebih baik</td>
            </tr>
            <tr>
                <td colspan="2" style="border-right: 1px solid black;">3.</td>
                <td colspan="2">3. Tenaga: Membutuhkan tenaga yang <br>lebih ahli/ Jumlah tenaga kurang</td>
            </tr>
            <tr>
                <td colspan="2" style="border-right: 1px solid black;">4.</td>
                <td colspan="2">4.  laian-lain sebutkan :...................</td>
            </tr>
            <tr>
                <td colspan="2">5.</td>
                <td colspan="2"></td>
            </tr>
        </table>