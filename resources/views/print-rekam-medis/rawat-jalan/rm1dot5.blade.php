<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.5</title>
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
            border:1px solid black;
            border-collapse: collapse;
        }
        .page_break{
    page-break-before: always;
}
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $eyero = storage_path('app/public/images/EYE-RO.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 1.5/CPPT/22
        </div>
        <table style="border-collapse: collapse;">
            {{-- HEADER --}}
            <tr style="border: 1px solid black;">
                <div style="width: 100%;">
                    <table style="width: 100%;">
                        <tr style="border: 1px solid black;">
                            <td style="border-right: 1px solid black; width:100%">
                                <img style="width: 100%;"
                                    src="data:image/png;base64,
                            <?php echo base64_encode(file_get_contents($fullpath)); ?>" />
                            </td>
                            <td style="width: 50%">
                                <table style="width: 100%" border="0">
                                    <tr>
                                        <td width="20%">Nama</td>
                                        <td width="1%">:</td>
                                        <td width=50%>..........</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Tgl. Lahir</td>
                                        <td width="1%">:</td>
                                        <td width=50%>..........</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">No.RM</td>
                                        <td width="1%">:</td>
                                        <td width=50%>..........</td>
                                    </tr>
                                    <tr>
                                        <td width="10%">NIK</td>
                                        <td width="1%">:</td>
                                        <td width=50%>..........</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </tr>
        </table>
        {{-- table content --}}
        <h3 style="text-align: center">CATATAN PERKEMBANGAN PASIEN TERINTEGERASI RAWAT JALAN</h3>
        <table class="tablee" style="width:100%; position:relative">
            <tr class="tablee">
                <th class="tablee">Tanggal/Jam</th>
                <th class="tablee">Profesionnal Pemberi Asuhan (PPA)</th>
                <th class="tablee">Hasil Asesmen Pasien dan Pemberian Pelayanan (SOAP)</th>
                <th class="tablee">Instruksi PPA Termasuk Pasca Bedah</th>
                <th class="tablee">Review & Verifikasi DPJP (Paraf)</th>
            </tr>
            <tr class="tablee" style="padding: 5px"> 
                <td class="tablee"> <br> </td>
                <td class="tablee"> <br> </td>
                <td class="tablee"> 
                    <table style="padding: 5px">
                        <tr>
                            <td> Subject :</td>
                        </tr> 
                        <br><br>
                        <tr>
                            <td> Object :</td>
                        </tr> 
                        <br><br>
                        <tr>
                            <td> Assassment :</td>
                        </tr> 
                        <br><br>
                        <tr>
                            <td> Plan :</td>
                        </tr>
                        <br><br> 
                    </table>
                 </td>
                 <td class="tablee"> <br> </td>
                 <td class="tablee"> <br> </td>
            </tr>
            <tr class="tablee" style="padding: 5px"> 
                <td class="tablee"> <br> </td>
                <td class="tablee"> <br> </td>
                <td class="tablee"> 
                    <table style="padding: 5px">
                        <tr>
                            <td> Subject :</td>
                        </tr> 
                        <br><br>
                        <tr>
                            <td> Object :</td>
                        </tr> 
                        <br><br>
                        <tr>
                            <td> Assassment :</td>
                        </tr> 
                        <br><br>
                        <tr>
                            <td> Plan :</td>
                        </tr>
                        <br><br> 
                    </table>
                 </td>
                 <td class="tablee"> <br> </td>
                 <td class="tablee"> <br> </td>
            </tr>

        </table>
    </div>
</body>
<?php

function bulans($bln)
{
    if ($bln == '01') {
        $bln = 'Januari';
    } elseif ($bln == '02') {
        $bln = 'Februari';
    } elseif ($bln == '03') {
        $bln = 'Maret';
    } elseif ($bln == '04') {
        $bln = 'April';
    } elseif ($bln == '05') {
        $bln = 'Mei';
    } elseif ($bln == '06') {
        $bln = 'Juni';
    } elseif ($bln == '07') {
        $bln = 'Juli';
    } elseif ($bln == '08') {
        $bln = 'Agustus';
    } elseif ($bln == '09') {
        $bln = 'September';
    } elseif ($bln == '10') {
        $bln = 'Oktober';
    } elseif ($bln == '11') {
        $bln = 'November';
    } elseif ($bln == '12') {
        $bln = 'Desember';
    }
    return $bln;
}

?>

</html>