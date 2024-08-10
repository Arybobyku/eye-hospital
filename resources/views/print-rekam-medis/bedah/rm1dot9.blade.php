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

        .tablee1dot9 {
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }

        .tablee21dot9 {
            border-top: 1px solid black;
            border-collapse: collapse;

        }

        .td11dot9 {
            border-right: 1px solid black;
            border-collapse: collapse;
        }

        .td21dot9 {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .smallfont1dot9 {
            font-size: 11;
        }

        .logo1dot9 {
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
    <?php $matakanan = storage_path('app/public/images/Matakanan.png'); ?>
    <?php $matakiri = storage_path('app/public/images/Matakiri.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 1.9/SM(PO)/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div class="smallfont1dot9">
        <table class="tablee1dot9" style="width: 100%; text-align: center;">
            <tr>
                <td style="text-align: center" colspan="4"><b>SITE MARKING (PENANDAAN OPERASI)</b></td>
            </tr>
        </table>
        <table class="tablee1dot9" style="width: 100%">
            <div style="text-align: center"> Beri tanda <b>Ya</b>(&#10004;) pada lokasi yang akan dioperasi menggunakan
                alat
                penanda atau <i>marker</i></td>
            </div>
            <br>
            <table  style="width: 50%; text-align:center; margin-left:25%">
                <tr>
                    <td class="td21dot9" style="text-align: right"> <input type="checkbox" checked></td>
                    <td class="td21dot9" style="text-align: left">MATA KANAN (OD)</td>

                    <td class="td21dot9" style="text-align: right"> <input type="checkbox" checked></td>
                    <td class="td21dot9" style="text-align: left">MATA KIRIa (OS)</td>
                </tr>
            </table>

            <table style="width: 50%; text-align:center; margin-left:25%">
                <tr style="text-align: center">

                    <td class="td21dot9"><img style="width: 100%;"
                        src="data:image/png;base64,
    <?php echo base64_encode(file_get_contents($matakanan)); ?>" /></td>
                    <td class="td21dot9"><img style="width: 100%;"
                        src="data:image/png;base64,
    <?php echo base64_encode(file_get_contents($matakiri)); ?>" /></td>

                </tr> <br>
                <tr>
                    <td colspan="4" style="align-text:canter;"> Tanggal :..................... Jam
                        :.....................
                    </td>
                </tr>
            </table>
            <table class="tablee21dot9" style="width: 100%;">
                <tr>
                    <td class="td11dot9">Tanda tangan Pasien/</td>
                    <td class="td11dot9">Tanda tangan Dokter</td>
                    <td>Tanda tangan perawat</td>
                </tr>
                <tr>
                    <td class="td11dot9">Keluarga</td>
                    <td class="td11dot9">Yang merawat</td>
                    <td>Penanggung Jawab</td>
                </tr>
                <tr>
                    <td class="td11dot9">(...................................)</td>
                    <td class="td11dot9">(...................................)</td>
                    <td>(...................................)</td>
                </tr>
                <tr>
                    <td class="td11dot9">Nama dan Tanda tangan</td>
                    <td class="td11dot9">Nama dan Tanda tangan</td>
                    <td>Nama dan Tanda tangan</td>
                </tr>
            </table>
        </table>
    </div>
</body>