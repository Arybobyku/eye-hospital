<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM8.7</title>
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
        .steps8dot7 {
            margin-left: -50px;
        }

        .step28dot7 {
            margin-left: -5px;
        }
        .step38dot7 {
            margin-left: 10px;
        }
        .section-10-11-8dot7 {
            margin-top: 8px;
        }
        .logo8dot7 {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 100px; /* Ubah ukuran sesuai kebutuhan Anda */
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

    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 8.7/FTLP/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div>
        <H4 style="text-align: center;">FORM TINDAKAN LASER PRP</H4>
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
        <p class="step38dot7">Langkah-langkah Tindakan Laser PRP : </p>
        <ol>
            <ol class="steps8dot7">
                <li>Pasien diberi obat tetes pelebar pupil mata (Mydriatyl 1%).</li>
                <li>Perawat mempersiapkan berkas kelengkapan tindakan laser.</li>
                <li>Perawat mengecek pupil mata pasien, jika pupil mata sudah lebar pasien masuk ke ruangan laser.</li>
                <li>Pasien diberi obat tetes Anestesi (Pantocain 0,5%).</li>
                <li>Pasien duduk menghadap ke alat laser.</li>
                <li>Pasien menempelkan dagu dan dahi ke peyangga pada alat laser.</li>
                <li>Dokter menyalakan alat Laser Photocoagulation.</li>
                <li>Pasien dipasang Lensa Super Quad/Trans Equator pada mata yang akan dilaser.</li>
                <li>Dilakukan tindakan laser dengan parameter (power) laser: 200 ms x 200 ms x 240 mW = 352</li>
            </ol>
    </div>
    <div class="section-10-11-8dot7">
        <ol start="10" class="step28dot7">
            <p>..........................................................................................................................................................................</p>
        </ol>
    </div>
    <div class="section-10-11-8dot7">
        <ol start="10" class="step28dot7">
            <li>Setelah selesai tindakan laser, pasien diberi obat tetes antibiotik.</li>
            <li>Pasien diberikan resep obat dan surat kontrol.</li>
        </ol>
    </div>
    <div>
        <table style="width: 100%; text-align: center;">
        <Tr>
            <td>Mata Kanan</td>
            <td>Mata kiri</td>
            <td rowspan="3"> Tanda Tangan DPJP/Dokter <br><br><br><br>(_____________________________)</td>
        </Tr>
        <TR>
            <TD><img src="images/header.png" alt="Logo" class="logo8dot7"></TD>
            <TD><img src="images/header.png" alt="Logo" class="logo8dot7"></TD>
            <TD rowspan="3"></TD>
        </TR>
        <TR>
            <TD><img src="images/header.png" alt="Logo" class="logo8dot7"></TD>
            <TD><img src="images/header.png" alt="Logo" class="logo8dot7"></TD>
            <TD rowspan="3"></TD>
        </TR>
    </table>
    </div>

</html>