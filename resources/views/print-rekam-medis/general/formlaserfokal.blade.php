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
		RM 10.6/FTLF/22
	</div>
	@include('print-rekam-medis.partials.header')
	<br />

	<br>

    <div style="font-weight: bold; text-align:center"> 
        FORM TINDAKAN LASER FOKAL
    </div>
    <br>
	<div class="">
		<span class="right"> Tanggal: __________________ </span>
	</div>

	<br>
	
	<table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">Diagnosa: ___________________________________________ <br>
		</tr>

		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
			Langkah-langkah Tindakan Laser Fokal :
			<br>
			</td>
			<br>
			<br>
			<br>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px">
			1.Pasien diberi obat tetes pelebar pupil mata (Mydriatyl 1%) <br>
            2.Perawat mempersiapkan berkas kelengkapan tindakan laser <br>
            3.Perawat mengecek pupil mata pasien, jika pupil mata sudah lebar pasien masuk ke ruangan laser <br>
            4.Pasien diberi obat tetes Anestesi (Pantocain 0,5%) <br>
            5.Pasien duduk menghadap ke alat laser <br>
            6.Pasien menempelkan dagu dan dahi ke peyangga pada alat laser <br>
            7.Dokter menyalakan alat Laser Photocoagulation <br>
            8.Pasien dipasang marker pada mata yang akan dilaser <br>
            9.Dilakukan tindakan laser dengan parameter laser : <br>
            <br>
            ...........................................................................................................................................
				<br>
                <br>
            10. Setelah selesai tindakan laser, pasien diberi obat tetes antibiotik <br>
            11. Pasien diberikan resep obat dan surat kontrol
            <br>
                <br>

                <div class="img-wrapper" style="margin-top: 50px">
                    <div class="text-above">Mata Kiri</div>
        <img style="width: 80%" src="\eye-hospital\storage\app\public\images\mataformlaserbarrage.png">
      </div>
 
      <div class="img-wrapper" style="margin-left: 85px">
        <div class="text-above">Mata Kanan</div> 
        <img style="width: 80%" src="\eye-hospital\storage\app\public\images\mataformlaserbarrage.png">
      </div>
      <br>
      <br>
      <div class="right">Tanda Tangan DPJP / Dokter </div>
      <div style="margin-left:20px">
        <img style="width: 50%" src="\eye-hospital\storage\app\public\images\formlaserbarrage.png">
      </div>
		</tr>

	</table>
</div>
</body>
</html>
