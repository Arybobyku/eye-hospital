<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REKAM MEDIS GENERAL - TINDAKAN LASER LPI</title>
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

        .fontsmall {
            font-size: 10;
        }

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
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $patimg = storage_path('app/public/images/PAT.png'); ?>
    
        <div class="wrap">
            <div style="width:100%; text-align:right; margin-bottom:5px">
                RM 10.3/FTLPI/22
            </div>
            @include('print-rekam-medis.partials.header')

            <div style="font-weight: bold; text-align:center; margin-top:10px"> 
         FORM TINDAKAN LASER PERIPHERAL IRIDECTOMY (LPI)
    </div>
    <br>


        <div style="margin-top: 5px; float: right">
        <span> Tanggal : __________________ </span>
        </div>
        <br>
        <br>
            <table style="width: 100%; text-align: left; margin-top:5px; padding-top:10px" cellpadding="0" cellspacing="0">
                <tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px;   text-align: justify">
                Diagnosa: _________________________________________________________________  
                <br>
            </td>
		</tr>   
        <br>
            <tr>
			<td style="width: 100%; font-size: 12pt;padding-top: 5px; line-height: 22px; padding-top: 5px; text-align: justify">
			Langkah-langkah Tindakan Laser Peripheral Iridectomy (LPI) : 
                <br>
                <br>
            1.Pasien diberi obat tetes pengecil pupil mata carpin <br>
            2.Perawat mempersiapkan berkas kelengkapan tindakan laser <br>
            3.Perawat mengecek pupil mata pasien, jika pupil mata sudah kecil pasien masuk ke ruangan laser <br>
            4.Pasien diberi obat tetes Anestesi (Pantocain 0,5%) <br>
            5.Pasien duduk menghadap ke alat laser <br>
            6.Pasien menempelkan dagu dan dahi ke peyangga pada alat laser <br>
            7.Dokter menyalakan alat Laser Peripheral Iridectomy <br>
            8.OVD/Viscuelastic diberikan pada lensa Ocular Abraham Iridectomy dan lensa dipasang pada <br>
              mata yang akan dilaser <br>
            9.Dilakukan tindakan Laser Peripheral Iridectomy (LPI) <br>

            ……………………………………………………………………………………………………….. <br>

            10. Setelah selesai tindakan laser, pasien diberi obat tetes antibiotik <br>
            11. Pasien diberikan resep obat dan surat kontrol 
            <br>
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
       <div style="margin-top: 5px; display:inline-block; float: right">
        Tanda Tangan DPJP / Dokter
        </div>
      <div style="margin-left:20px">
        <img style="width: 50%" src="\eye-hospital\storage\app\public\images\formlaserbarrage.png">
      </div>
            </td>
            </tr>
                
            </table>


   
</body>

</html>
