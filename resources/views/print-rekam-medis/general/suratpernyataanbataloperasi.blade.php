<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - SURAT PERNYATAAN BATAL OPERASI</title>
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
        SURAT PERNYATAAN BATAL OPERASI
    </div>
	
    <br>

    <div>Yang bertandatangan di bawah ini menerangkan bahwa:</div>

	<table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
      <tr>
    <td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">Nama</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
        <tr>
			<td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">
        Jenis Kelamin </td>
        <td style="width: 10px"> : </td>
        <td> ..................... </td>
        <br>
        </tr>

        <tr>
			<td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">
        Tempat, Tanggal Lahir</td>
        <td style="width: 10px"> : </td>
        <td> ..................... </td>
        <br>
        </tr>
  </table>
        
        <br>
  <br>
    <br>
    <div style="font-size: 12pt">
        Pasien diatas dinyatakan batal melakukan operasi yang dijadwalkan pada tanggal (.............) dikarenakan tensi darahnya yang tinggi. Saran dari Dokter DPJP (............) untuk dilakukan konsultasi ke dokter penyakit spesialis penyakit dalam. Namun pasien menolak dan memilih pulang ke rumah.
        <br>
        <br>
          Demikian surat pernyataan ini diberikan, untuk diketahui dan dipergunakan sebagaimana mestinya.
          <br>
          <br>
    <br>
    </div>
  <div class="right">Medan, ............................... 2025 
      <br>  
     Dokter Pemeriksa
     <br>
     <br>
     <br>
     <br>
     <br>
     (………………………………..)
  </div>
      <br> 
      <br>
      <br>
      <br>
      {{-- <br>
       <div style="display: inline-block; float: right; margin-right:50px">(………………………………..) </div> --}}
</div>
</body>
</html>
