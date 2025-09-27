<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - SURAT KONSUL</title>
    <style>
    @page { margin: 18px; }
    body { margin: 18px; }
        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }
	

		.left { display: inline-block; float: left; }
		.right { display: inline-block; float: right;}

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


   .text-above {
    text-align: center;   
    margin-bottom: 5px;  
  }


    </style>
    
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;">
</div>
<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  
<div class="wrap">
	<div style="width:100%; text-align:right; margin-bottom:5px">
		RM 10.0/FPAPS/22
	</div>
	@include('print-rekam-medis.partials.header')
	<br />

	<br>

    <div style="font-weight: bold; text-align:center"> 
        FORMULIR PULANG ATAS PERMINTAAN SENDIRI
    </div>
	
	<table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify"> Yang Bertanda tangan di bawah ini : <br>
		</tr>
        <br>

		<tr>
            <td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px">
				Nama Pasien :  <br>
				Tempat/Tanggal Lahir : 	<br>
				Nomor Rekam Medis :	<br>
                Agama : <br>
                Pekerjaan : <br>
                Alamat : <br>
				<br>
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px">
                Dengan ini menyatakan permintaan untuk menghentikan perawatan/pengobatan dan meminta pulang <br> atas permintaan sendiri dengan alasan : <br>
                ………………………………………………………………………………………………………………………..<br> 
                .…………………………………………………………………………………………………………………….. <br>
                    Sebagai pasien/keluarga pasien,saya telah mendapatkan penjelasan dari rumah sakit tentang : <br>
                    <br>
                1.Hak saya menolak atau tidak melanjutkan pengobatan. <br>
                2.Tentang konsekuensi dari Keputusan saya untuk pulang atas permintaan sendiri. <br>
                3.Tentang tanggung jawab saya dengan Keputusan tersebut. <br>
                4.Tersedianya alternatif pelayanan dan pengobatan untuk pengobatan lanjutan. <br>
                Dan saya tidak akan menuntut pihka rumah sakit atau siapapun juga akibat dari Keputusan saya pulang atas permintaan sendiri.
            <br>
            <br>

      <div class="right">Medan, ............................... 2025 </div>
      <br>
      <br>
      <br>
      <div style="display: inline-block; margin-left:80px"> 
        Keluarga/Pasien
      </div>
       <div style="display: inline-block; float: right; margin-right:130px">DPJP </div>
      <br> 
      <br>
      <br>
      <br>
      <br>
      <div style="display: inline-block; margin-left:35px"> 
        (………………………………..)
      </div>
       <div style="display: inline-block; float: right; margin-right:50px">(………………………………..) </div>
     
       <div style="display: inline-block; margin-left:40px"> 
        Nama Jelas & Tanda Tangan
      </div>
       <div style="display: inline-block; float: right; margin-left:30px">Nama Jelas & Tanda Tangan </div>

		</tr>
        
		<br>
		<br>

	</table>
</div>
</body>
</html>
