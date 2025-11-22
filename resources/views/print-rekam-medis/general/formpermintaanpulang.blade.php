<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - FORM PERMINTAAN PULANG ATAS PERMINTAAN SENDIRI</title>
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

      <br>
	
        <div>Yang bertanda tangan dibawah ini :</div>

        <table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
              <tr>
    <td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">Nama Pasien</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
        <tr>
			<td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">
        Tempat/Tanggal Lahir </td>
        <td style="width: 10px"> : </td>
        <td> ..................... </td>
        <br>
        </tr>

        <tr>
			<td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">
        Nomor Rekam Medis </td>
        <td style="width: 10px"> : </td>
        <td> ..................... </td>
        <br>
        </tr>
        <tr>
        <td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">
        Agama </td>
        <td style="width: 10px"> : </td>
        <td> ..................... </td>
        <br>
        </tr>
        <tr>
        <td style="width: 180px; font-size: 12pt; line-height: 22px; padding-top: 5px">
        Pekerjaan </td>
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
                <div>
			           Dengan ini menyatakan permintaan untuk menghentikan perawatan/pengobatan dan meminta pulang <br> atas permintaan sendiri dengan alasan : <br>
                ………………………………………………………………………………………………………………………..<br> 
                .…………………………………………………………………………………………………………………….. <br>
                <br>
                    Sebagai pasien/keluarga pasien,saya telah mendapatkan penjelasan dari rumah sakit tentang : <br>
                    <br>
                1.Hak saya menolak atau tidak melanjutkan pengobatan. <br>
                2.Tentang konsekuensi dari Keputusan saya untuk pulang atas permintaan sendiri. <br>
                3.Tentang tanggung jawab saya dengan Keputusan tersebut. <br>
                4.Tersedianya alternatif pelayanan dan pengobatan untuk pengobatan lanjutan. <br>
                <br>
                Dan saya tidak akan menuntut pihka rumah sakit atau siapapun juga akibat dari Keputusan saya pulang atas permintaan sendiri.
            <br>
            <br>
                </div>

      <div style="display: inline-block; float: right; margin-right:35px">Medan, ............................... 2025 </div>
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
        (………………………………..)<br>
        <div style="text-align: center">Nama Jelas & Tanda Tangan </div>
      </div>
       <div style="display: inline-block; float: right; margin-right:45px">(………………………………..) <br>
        <div style="text-align: center">Nama Jelas & Tanda Tangan </div>

       </div>

		</tr>
        
		<br>
		<br>

	</table>
</div>
</body>
</html>
