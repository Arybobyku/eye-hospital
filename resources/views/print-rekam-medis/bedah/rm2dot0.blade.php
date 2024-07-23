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

        .tablee2dot0 {
            border: 1px solid black;
            border-collapse: collapse;
            border-top:0.5px solid;
            border-bottom:0.5px solid;
        }

        .td12dot0 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }
        .td12dot0x {
            border-top: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }

        .td22dot0 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }
        .td12dot0y {
            border-left: 1px solid black;
            border-top: 1px solid black;
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
    <table class="tablee2dot0" style="width: 100%;">
        <tr>
            <td style="text-align: center" colspan="4"><b>CHECKLIST KESIAPAN BEDAH</b></td>
        </tr>
        <tr>
            <td class="td12dot0x">Ruang</td>
            <td class="td12dot0x">: {{ $ckb->ruangan }}</td>
            <td class="td12dot0y">Kamar</td>
            <td class="td12dot0x">: {{ $ckb->kamar }}</td>

        </tr>
        <tr class="tablee2dot0">
            <td class="td12dot0x">Diagnosis</td>
            <td class="td12dot0x">: {{ $ckb->diagnosa }}</td>
            <td class="td12dot0y">Tindakan</td>
            <td class="td12dot0x">: {{ $ckb->tindakan }}</td>
        </tr>
        <tr class="tablee2dot0">
            <td class="td12dot0x">Tehknik anastesi</td>
            <td class="td12dot0x">: {{ $ckb->teknik_anastesi }}</td>
            <td class="td12dot0y">Tgl. Tindakan</td>
            <td class="td12dot0x">: {{ $ckb->tanggal_tindakan }}</td>
        </tr>
    </table>
        <table  style="width: 100%; border:1px solid; border-top:0.5px">
        <tr>
            <td colspan="2"><b>listrik</b></td>
        </tr>        
        <tr>            
            <td><input type="checkbox" {{ $listrik[0]?'checked': '' }}></td>
            <td>Mesin anastesi terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $listrik[1]?'checked': '' }}></td>
            <td>Mesin Phaco terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $listrik[2]?'checked': '' }}></td>
            <td>Light source, monitor Mata terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $listrik[3]?'checked': '' }}></td>
            <td>Extension kabel,terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $listrik[4]?'checked': '' }}></td>
            <td>Meja operasi terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $listrik[5]?'checked': '' }}></td>
            <td>Microskop terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $listrik[6]?'checked': '' }}></td>
            <td>Lampu kamar operasi menyala</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $listrik[7]?'checked': '' }}></td>
            <td>AC berfungsi dengan baik</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $listrik[8]?'checked': '' }}></td>
            <td>Gas medis terhubung dengan mesin, indicator (+)</td>   
        </tr>
        <br>
        <tr>
            <td colspan="2"><b>Alat</b></td>
        </tr>        
        <tr>            
            <td><input type="checkbox" {{ $alat[0]?'checked': '' }}></td>
            <td>Casette, selang, Diatermi dan konektor Mesin Phaco sudah tersedia</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $alat[1]?'checked': '' }}></td>
            <td>Patient plate sudah tersedia</td>   
        </tr>
        <tr>            
            <td><input type="checkbox"  {{ $alat[2]?'checked': '' }}></td>
            <td>Insument steril sesuai kebutuhan sudah tersedia </td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $alat[3]?'checked': '' }}></td>
            <td>Handle Microskop steril</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $alat[4]?'checked': '' }}></td>
            <td>Kom kidney steril sudah tersedia</td>   
        </tr>
        <br>
        <tr>
            <td colspan="2"><b>Linen Steril</b></td>
        </tr>        
        <tr>            
            <td><input type="checkbox" {{ $linen_steril[0]?'checked': '' }}></td>
            <td>Jas steril</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $linen_steril[1]?'checked': '' }}></td>
            <td>Duk Steril</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $linen_steril[2]?'checked': '' }}></td>
            <td>Linen meja instrumen</td>   
        </tr>
        <tr>            
            <td><input type="checkbox" {{ $linen_steril[3]?'checked': '' }}></td>
            <td>Kasa</td>   
        </tr>
        <br>
        <tr>
            <td colspan="2"><b>AKHP</b></td>
        </tr>        
        <tr>            
            <td><input type="checkbox" {{ $ckb->akhp != '' ? 'Checked' : '' }}></td>
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
                            : {{ $ckb->perawat_kamar_bedah }}
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
                            : {{ $ckb->kepala_ruangan }}
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