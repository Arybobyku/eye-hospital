<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM3.5</title>
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
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }
        .tablee4{
            border-top: 1px solid black;
            border-bottom: 1px solid black;
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
                <td style="border-right:1px solid black; padding-left: 5px; ">Tanggal Masuk :</td>
                <td style="padding-left: 5px;">Tanggal Keluar :</td>
            </tr>
            <tr>
                <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Ruang Rawat Terakhir:</td>
                <td style="border-top:1px solid black; padding-left: 5px;">Penanggung Pembayaran:</td>
            </tr>
            <tr>
                <td colspan="2" style="border-top:1px solid black; padding-left: 5px;">Dokter Penanggung Jawab (DPJP)
                    : dr............................</td>
            </tr>
        </table>
        <table class="tablee2" style="width: 100%">
            <tr>
                <td style="padding-left: 5px;">Rawat Tim Dokter:</td>
                <td><input type="checkbox"></td>
                <td>Tidak</td>
                <td><input type="checkbox"></td>
                <td>Ya, Oleh</td>
                <td>1. dr....................</td>
                <td>3. dr....................</td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td>2. dr....................</td>
                <td>4. dr....................</td>
            </tr>
        </table>
        <table class="tablee" style="width: 100%">
            <tr>
                <td style="padding-left: 5px;">Alasan Dirawat</td>
            </tr>
            <tr>
                <td style="border-top:1px solid black; padding-left: 5px;">Didiagnosa Masuk</td>
            </tr>
        </table>
        <table class="tablee2" style="width: 100%">
            <tr>
                <td style="border-right:1px solid black; width:25%; padding-left: 5px;"> Didagnosis Keluar (Diagnosa Utama)</td>
                <td style="width:50%;"> </td>
                <td style="border-left:1px solid black; width:25%; padding-left: 5px;">ICD</td>
            </tr>
            <tr>
                <td style="border-right:1px solid black; width:25%; border-top:1px solid black; width:25%; padding-left: 5px;"> Diagnosis
                    Sekunder</td>
                <td style="width:50%;  border-top:1px solid black; width:25%; padding-left: 5px; ">1.
                    .......................................</td>
                <td style="border-left:1px solid black;  border-top:1px solid black; width:25%;"></td>
            </tr>
            <tr>
                <td style="border-right:1px solid black; width:25%;"></td>
                <td style="width:50%; padding-left: 5px;">2. ....................................... </td>
                <td style="border-left:1px solid black; width:25%; "></td>
            </tr>
            <tr>
                <td style="border-right:1px solid black; width:25%;"></td>
                <td style="width:50%; padding-left: 5px;">3. ....................................... </td>
                <td style="border-left:1px solid black; width:25%; "></td>
            </tr>
            <tr>
                <td style="border-right:1px solid black; width:25%;"></td>
                <td style="width:50%; padding-left: 5px;">4. ....................................... </td>
                <td style="border-left:1px solid black; width:25%; "></td>
            </tr>
            <tr>
                <td style="border-right:1px solid black; width:25%; border-top:1px solid black; width:25%; padding-left: 5px;"> Penyebab
                    Kematian (Secara klinis)</td>
                <td style="width:50%;  border-top:1px solid black; width:25%; "></td>
                <td style="border-left:1px solid black;  border-top:1px solid black; width:25%;"></td>
            </tr>
            <tr>
                <td style="border-right:1px solid black; width:25%; border-top:1px solid black; width:25%; padding-left: 5px;">Pemeriksaan
                    Fisik <br>Yang Penting</td>
                <td style="width:50%;  border-top:1px solid black; width:25%; "></td>
                <td style="border-left:1px solid black;  border-top:1px solid black; width:25%;"></td>
            </tr>
            <tr>
                <td style="border-right:1px solid black; width:25%; border-top:1px solid black; width:25%; padding-left: 5px;" > Laboratrium
                    <br>Yang Penting</td>
                <td style="width:50%;  border-top:1px solid black; width:25%; "></td>
                <td style="border-left:1px solid black;  border-top:1px solid black; width:25%;"></td>
            </tr>
        </table>
        <table class="tablee" style="width: 100%">
            <tr>
                <td style="border-Right:1px solid black; width:51.1%; padding-left: 5px;">Radiologi</td>
                <td></td>
            </tr>
            <tr>
                <td style="border-Right:1px solid black; border-top:1px solid black; width:51.1%; padding-left: 5px;">Penunjang Lain</td>
                <td style="border-top: 1px solid black;"></td>
            </tr>
        </table>
        <table class="tablee2" style="width: 100%">
            <tr>
                <td style="border-right: 1px solid black; width:51.1%; padding-left: 5px;">Tindakan/Operasi</td>
                <td></td>
                <td style="border-left: 1px solid black; width:20%; padding-left: 5px;"> ICD</td>
            </tr>
        </table>
        <table class="tablee" style="width: 100%">
            <tr>
                <td style="width:51.1%; border-right:1px solid black; padding-left: 5px;">Pengobatan Selama Dirawat</td>
                <td></td>
            </tr>
        </table>
        <table class="tablee3" style="width: 100%">
            <tr>
                <td colspan="2" style="border-right: 1px solid black; padding-left: 5px; ">Kondisi Pulang</td>
                <td style="width: 50%; padding-left: 5px;">Instruksi dan Edukasi Lanjutan (follow up)</td>
            </tr>
            <tr>
                <td style="padding-left: 5px;"><input type="checkbox"></td>
                <td style="border-right: 1px solid black; width: 48%; ">Sembuh</td>
                <td style="border-top: 1px solid black; padding-left: 5px;">Kontrol Tanggal:</td>
            </tr>
            <tr>
                <td style="padding-left: 5px;"><input type="checkbox"></td>
                <td style="border-right: 1px solid black;">Pindah RS</td>
                <td style="border-top: 1px solid black; padding-left: 5px;">Diet:</td>
            </tr>
            <tr>
                <td style="padding-left: 5px;"><input type="checkbox"></td>
                <td style="border-right: 1px solid black;">Pulang atas Permintaan Sendiri</td>
                <td style="border-top: 1px solid black; padding-left: 5px;">Latihan:</td>
            </tr>
            <tr>
                <td style="padding-left: 5px;"><input type="checkbox"></td>
                <td style="border-right: 1px solid black;">Meninggal</td>
                <td style="border-top: 1px solid black; padding-left: 5px;">Segera kembali ke rumah sakit, Langsung ke </td>
            </tr>
            <tr>
                <td style="padding-left: 5px;"><input type="checkbox"></td>
                <td style="border-right: 1px solid black;">Lain-lain</td>
                <td  style="padding-left: 5px;">Gawat darurat, Bila Terjadi: </td>
            </tr>
        </table>
        <div class="page_break"></div>
        <table class="tablee" style="width:100%">
            <tr>
                <td style="padding-left: 5px;"><b>Terapi Pulang</b></td>
            </tr>
            <table class="tablee4" style="width:100%">
                <tr>
                    <td style="border-right:1px solid black; padding-left: 5px;">Nama Obat</td>
                    <td style="border-right:1px solid black; padding-left: 5px;">Jumlah</td>
                    <td style="border-right:1px solid black; padding-left: 5px;">Dosis</td>
                    <td style="border-right:1px solid black; padding-left: 5px;">Frekuensi</td>
                    <td style="border-right:1px solid black; padding-left: 5px;">Cara Pemberian</td>
                    <td style="border-right:1px solid black; padding-left: 5px;">Nama Obat</td>
                    <td style="border-right:1px solid black; padding-left: 5px;">Jumlah</td>
                    <td style="border-right:1px solid black; padding-left: 5px;">Dosis</td>
                    <td style="border-right:1px solid black; padding-left: 5px;">Frek</td>
                    <td>Cara Pemberian</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black;"> &nbsp;</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;">&nbsp;</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;">&nbsp;</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;">&nbsp;</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;">&nbsp;</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;">&nbsp;</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;">&nbsp;</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;">&nbsp;</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;">&nbsp;</td>
                    <td style="border-top:1px solid black;">&nbsp; </td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr style="padding-left: 5px;">
                    <td>Tanggal,..........................Jam:.................WIB</td>
                </tr>
                <tr>
                    <td style="text-align: center">Yang Membuat</td>
                </tr>
                <tr>
                    <td style="text-align: center"> ....................................................</td>
                </tr>
                <tr>
                    <td style="text-align: center">Nama Jelas dan Tanda Tangan</td>
                </tr>
            </table>
        </table>
        <table style="width: 100%">
            <tr>
                <td style="text-align: right"><b>Page 2 to 2</b></td>
            </tr>
            <tr>
                <td><i>1. Lembar Asli Untuk arsip Rekam Medis</i></td>
            </tr>
            <tr>
                <td><i>2. Lembar Kedua Untuk Pasien</i></td>
            </tr>
            <tr>
                <td><i>3. Lembar Ketiga Untuk Penjamin</i></td>
            </tr>
        </table>

    </div>
</body>