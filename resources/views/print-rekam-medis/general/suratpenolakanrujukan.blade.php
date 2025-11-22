<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - SURAT PENOLAKAN RUJUKAN</title>
    <style>
    @page { margin: 18px; }
    body { margin: 18px; }
        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }
	

		.left { display: inline-block; float: left; }
		.right { display: inline-block; float: right; margin-right: 30px;}

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
	
    <br>

    <div>Saya yang bertanda tangan dibawah ini :</div>

	<table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
      <tr>
    <td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">Nama</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
        <tr>
			<td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">
        NIK </td>
        <td style="width: 10px"> : </td>
        <td> ..................... </td>
        <br>
        </tr>

        <tr>
			<td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">
        Alamat </td>
        <td style="width: 10px"> : </td>
        <td> ..................... </td>
        <br>
        </tr>
  </table>
        
        <br>

		<div style="font-size: 12pt">
         Selaku keluarga / pendamping telah mendapatkan penjelasan tentang keadaan pasien oleh dokter, menyatakan bahwa pasien :
    </div>
    <table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">
        Nama Pasien </td>
        <td style="width: 10px"> : </td>
        <td> ..................... </td>
        <br>
    </tr>
        <tr>
			<td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">
        NIK</td>
        <td style="width: 10px"> : </td>
        <td> ..................... </td>
        <br>
        </tr>

        <tr>
			<td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">
        No. RM</td>
        <td style="width: 10px"> : </td>
        <td> ..................... </td>
        <br>
        </tr>

        <tr>
			<td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">
        Alamat </td>
        <td style="width: 10px"> : </td>
        <td> ..................... </td>
        <br>
        </tr>

		</tr>

	</table>

  <br>

  <div style="font-weight: bold; text-align:center"> 
        "MENOLAK DIRUJUK"
    </div>
    <br>
    <div style="font-size: 12pt">
        Persetujuan ini diberikan dengan penuh kesadaran dengan kemungkinan terjadinya akibat sampingan dari tindakan tersebut diluar dari tanggung jawab RSK Mata Prima Vision. <br>
        <br>
          Demikian surat persetujuan ini dibuat dengan rasa tanggung jawab dan tanpa paksaan.
          <br>
          <br>
    <br>
    </div>
  <div class="right">Medan, ............................... 2025 </div>
      <br>
      <br>
      <div style="display: inline-block; margin-left:80px; margin-top:5px"> 
        Mengetahui Dokter
      </div>
       <div style="display: inline-block; float: right; margin-right:65px">Yang Membuat Pernyataan, </div>
      <br> 
      <br>
      <br>
      <br>
      <br>
      <div style="display: inline-block; margin-left:35px"> 
        (………………………………..)
      </div>
       <div style="display: inline-block; float: right; margin-right:50px">(………………………………..) </div>
</div>
</body>
</html>
