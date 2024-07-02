<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM2.0</title>
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
            border-top:0.5px solid;
            border-bottom:0.5px solid;
        }

        .td1 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }

        .td2 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }

    </style>
<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 2.0/CKB/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <table class="tablee" style="width: 100%;">
        <tr>
            <td style="text-align: center" colspan="2"><b>CHECKLIST KESIAPAN BEDAH</b></td>
        </tr>
        <tr>
            <td class="td1">Ruang :</td>
            <td class="td2">Kamar :</td>

        </tr>
        <tr class="tablee">
            <td class="td1">Diagnosis :</td>
            <td class="td2">Tindakan :</td>
        </tr>
        <tr class="tablee">
            <td class="td1">Tehknik anastesi :</td>
            <td class="td2">Tgl. Tindakan:</td>
        </tr>
    </table>
        <table  style="width: 100%; border:1px solid; border-top:0.5px">
        <tr>
            <td colspan="2"><b>listrik</b></td>
        </tr>        
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Mesin anastesi terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Mesin Phaco terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Light source, monitor Mata terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Extension kabel,terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Meja operasi terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Microskop terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Lampu kamar operasi menyala</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>AC berfungsi dengan baik</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Gas medis terhubung dengan mesin, indicator (+)</td>   
        </tr>
        <br>
        <tr>
            <td colspan="2"><b>Alat</b></td>
        </tr>        
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Casette, selang, Diatermi dan konektor Mesin Phaco sudah tersedia</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Patient plate sudah tersedia</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Insument steril sesuai kebutuhan sudah tersedia </td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Handle Microskop steril</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Kom kidney steril sudah tersedia</td>   
        </tr>
        <br>
        <tr>
            <td colspan="2"><b>Linen Steril</b></td>
        </tr>        
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Jas steril</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Duk Steril</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Linen meja instrumen</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Kasa</td>   
        </tr>
        <br>
        <tr>
            <td colspan="2"><b>AKHP</b></td>
        </tr>        
        <tr>            
            <td><input type="checkbox" checked></td>
            <td>Tersedia AKHP sesuai kebutuhan </td>   
        </tr>
        <br>
        <tr>
            <td colspan="2 ">
                <table style="width: 100%;" border="0">
                    <tr>
                        <td colspan="2"><b>Pemeriksaan</b></td>
                    </tr>  
                    <tr>
                        <td  style="width:100px">
                            Perawat Kamar Bedah
                        </td>
                        <td style="width:100px">
                            :.............................
                        </td>
                        <td style="width:100px">
                            Tanda tangan 
                        </td>
                        <td  style="width:100px">
                            :.............................
                        </td>
                    </tr> 
                    <tr>
                        <td  style="width:100px">
                            Kepala Ruangan
                        </td>
                        <td style="width:100px">
                            :.............................
                        </td>
                        <td style="width:100px">
                            Tanda tangan 
                        </td>
                        <td  style="width:100px">
                            :.............................
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </table>
</head>