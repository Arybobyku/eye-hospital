<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - SURAT PERNYATAAN PASIEN UMUM</title>
    <style>
    @page { margin: 18px; }
    body { margin: 18px; }
        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }
	

		.left { display: inline-block; float: left; }
		.right { display: inline-block; float: right; margin-right: 65px;}

        .img-wrapper {
    position: relative;
    display: inline-block; 
    text-align: center;
  } 

  .img-wrapper img {
    display: block;
    max-width: 100%;
    height: auto;
  }
  .tablee {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 5px;
  }

   .text-above {
    text-align: center;   
    margin-bottom: 5px;  
  }

    </style>
    
</head>
<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme4.png');  ?>  
    <div class="wrap">
	    <div style="width:100%; text-align:right; margin-bottom:5px">RM 9.10/SPPU/22</div>
	    @include('print-rekam-medis.partials.header5')
    </div>
    <table style="width:100%; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <td style="width:35%; padding-left: 5px;">Nama Dokter :...................................</td>
            <td style="width:35%;">Admission Date :.................................</td>
            <td style="width:30%;"> Discharge Date :..........................</td>
        </tr>
    </table> <br>
    <table style="width:100%; border-collapse: collapse; border: 1px solid black; margin-top: 5px;  text-align: center;">
        <tr>
            <td class="tablee" style="width:10%;">HARI</td>
            <td class="tablee" style="width:20%;">TANGGAL-JAM</td>
            <td class="tablee" style="width:10%;">PARAF DOKTER</td>
            <td class="tablee" style="width:10%;">PARAF PERAWAT</td>
            <td class="tablee" style="width:10%;">HARI</td>
            <td class="tablee" style="width:20%;">TANGGAL-JAM</td>
            <td class="tablee" style="width:10%;">PARAF DOKTER</td>
            <td class="tablee" style="width:10%;">PARAF PERAWAT</td>
        </tr>
        <tr>
            <td class="tablee" style="width:10%;"></td>
            <td class="tablee" style="width:20%;"></td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"></td>
            <td class="tablee" style="width:20%;"></td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"> </td>
        </tr>
        <tr>
            <td class="tablee" style="width:10%;"></td>
            <td class="tablee" style="width:20%;"></td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"></td>
            <td class="tablee" style="width:20%;"></td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"> </td>
        </tr>
        <tr>
            <td class="tablee" style="width:10%;"></td>
            <td class="tablee" style="width:20%;"></td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"></td>
            <td class="tablee" style="width:20%;"></td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"> </td>
        </tr>
        <tr>
            <td class="tablee" style="width:10%;"></td>
            <td class="tablee" style="width:20%;"></td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"></td>
            <td class="tablee" style="width:20%;"></td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"> </td>
        </tr>
        <tr>
            <td class="tablee" style="width:10%;"></td>
            <td class="tablee" style="width:20%;"></td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"></td>
            <td class="tablee" style="width:20%;"></td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"> </td>
        </tr>
        <tr>
            <td class="tablee" style="width:10%;"></td>
            <td class="tablee" style="width:20%;"></td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"></td>
            <td class="tablee" style="width:20%;"></td>
            <td class="tablee" style="width:10%;"> </td>
            <td class="tablee" style="width:10%;"> </td>
        </tr>
        <tr>
            <td colspan="8" style="
                font-style: italic;
                font-weight: bold;
                font-size: 12px;
                text-align: center;
                padding: 4px;">
                FORMULIR INI HANYA UNTUK SATU DOKTER. HARAP GUNAKAN FORMULIR LAIN UNTUK DOKTER YANG BERBEDA
            </td>        
        </tr>
    </table>
</div> <br> <br>
<div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme4.png');  ?>  
    <div class="wrap">
	    @include('print-rekam-medis.partials.header6')
    </div>
    <table style="width:100%; border-collapse: collapse; border: 1px solid black; text-align: left;">
        <tr>
            <td colspan="2">Perawatan-Visite (Kunjungan) </td>
            <td colspan="2">: Rp.................../Hari</td>
        </tr>
        <tr>
            <td colspan="2" >Jenis Tarif Operasi</td>
            <td colspan="2" >
                <table >
                    <tr>
                        <td>: Pribadi</td>
                        <td><input type="checkbox"></td>
                        <td>Rumah Sakit</td>
                        <td><input type="checkbox"></td>
                        <td>Perusahaan</td>
                        <td><input type="checkbox"></td>
                        <td>Staff RSKMPV</td>
                        <td><input type="checkbox"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table style="width:100%;">
                    <tr>
                        <td style="width:10%;">Operasi</td>
                        <td style="width:30%;">- Besar</td>
                        <td style="width:60%;">: Rp...................</td>
                    </tr>
                    <tr>
                        <td><br></td>
                        <td>- Sedang</td>
                        <td>: Rp...................</td>
                    </tr>
                    <tr>
                        <td><br></td>
                        <td>- Kecil</td>
                        <td>: Rp...................</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">Anasthesi</td>
            <td colspan="2"> : ............................</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="2">Dokter Konsultan</td>
            <td colspan="2"> : ............................</td>
        </tr>
        <tr>
            <td colspan="4">
                <table style="width:100%;">
                    <tr>
                        <td style="width:10%;">Partus</td>
                        <td style="width:30%;">- Biasa/Normal</td>
                        <td style="width:60%;">: Rp...................</td>
                    </tr>
                    <tr>
                        <td style="width:10%;"><br></td>
                        <td style="width:30%;">- Vacucm. Biopsy</td>
                        <td style="width:60%;">: Rp...................</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="tablee">Date :</td>
            <td class="tablee">Time :</td>
            <td class="tablee">Dibuat Oleh :</td>
            <td class="tablee">(Tanda Tangan & Nama Jelas)</td>
        </tr>
        <tr>
            <td class="tablee"></td>
            <td class="tablee"></td>
            <td class="tablee">Kepala Keparawatan</td>
            <td class="tablee">Dr. </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center; font-size: 12px;">JIKA DOKTER MEMBERITAHUKAN HONORNYA MELALUI TELEPON ATAUPUN SECARA LISAN, MOHON KEPADA ST 
            YANG MENERIMANYA MENJELASKAN NAMA DAN TANDA TANGAN DI FORM INI UNTUK MEWAKILI DOKTER. </td>
        </tr>
    </table>
</div>
</body>
</html>
