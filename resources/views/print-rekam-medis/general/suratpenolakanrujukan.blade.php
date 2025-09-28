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
		RM 9.5/SPPR/22
	</div>
	@include('print-rekam-medis.partials.header')
	<br />

	<br>

    <div style="font-weight: bold; text-align:center"> 
        SURAT PERNYATAAN PENOLAKAN RUJUKAN
    </div>
	
	<table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
		<tr>
			<td> Saya yang bertanda tangan dibawah ini : <br>

        <br>
				Nama Pasien :  <br>
				NIK : 	<br>
				Alamat :	<br>
				<br>
        Selaku keluarga / pendamping telah mendapatkan penjelasan tentang keadaan pasien oleh dokter, menyatakan bahwa pasien :
        <br>
      </td>
      </tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px">
        Nama Pasien :  <br>
				NIK : 	<br>
				Alamat :	<br>

        <div style="font-weight: bold; text-align:center"> 
        SURAT PERNYATAAN PENOLAKAN RUJUKAN
    </div>
    <br>
        Persetujuan ini diberikan dengan penuh kesadaran dengan kemungkinan terjadinya akibat sampingan dari tindakan tersebut diluar dari tanggung jawab RSK Mata Prima Vision. <br>
        <br>
          Demikian surat persetujuan ini dibuat dengan rasa tanggung jawab dan tanpa paksaan.
          <br>
          <br>
    <br>
      <div class="right">Medan, ............................... 2025 </div>
      <br>
      <br>
      <div style="display: inline-block; margin-left:80px; margin-top:5px"> 
        Mengetahui Dokter
      </div>
       <div style="display: inline-block; float: right; margin-right:65px">Yang Membuat Pernyataan </div>
      <br> 
      <br>
      <br>
      <br>
      <br>
      <div style="display: inline-block; margin-left:35px"> 
        (………………………………..)
      </div>
       <div style="display: inline-block; float: right; margin-right:50px">(………………………………..) </div>

		</tr>


	</table>
</div>
</body>
</html>
