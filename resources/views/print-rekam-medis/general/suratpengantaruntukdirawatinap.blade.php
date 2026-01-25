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
		RM 2.5/SPUDI22
	</div>
	@include('print-rekam-medis.partials.header')
<table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
    <tr>
        <td style="font-weight: bold; text-align: center; padding: 7px;">
            SURAT PENGANTAR UNTUK DIRAWAT INAP
        </td>
    </tr>
</table>

    <table style="width: 100%;  border: 1px solid black; cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30%" style="padding-left: 7px;">Asal Ruangan</td>
            <td width="1%">:</td>
            <td width="69%">
                <table style="width:100%; border:none;">
                    <tr>
                        <td width="1%"><input type="checkbox"></td>
                        <td width="9%">IGD</td>
                        <td width="1%"><input type="checkbox"></td>
                        <td width="89%">Poliklinik, ................</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td  style="padding-left: 5px; padding: 30px 7px;">Rencana Perawatan di</td>
            <td > : </td>
            <td >........................................................</td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 10px 7px; ">Bersama ini kami kirimkan pasien tersebut diatas untuk dirawat inap :</td>

        </tr>
        <tr>
            <td style="padding: 30px 7px;">Karena Menderita</td>
            <td> : </td>
            <td >........................................................</td>
        </tr>
        <tr>
            <td style=" padding: 30px 7px;">Saran Terapi</td>
            <td> : </td>
            <td >........................................................</td>
        </tr>
                <tr>
            <td style="padding: 30px 7px;">Rencana Tindakan</td>
            <td> : </td>
            <td >........................................................</td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 10px 7px;">Mohon ditindaklanjuti untuk rencana tindakan terapi. </td>
        </tr>

        <tr>
            <td colspan="3" style="text-align: center; padding-top: 60px;">Medan, Tgl..............</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center;">Dokter yang memeriksa</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center; padding-top: 90px; padding-bottom: 10px;">(............................................)</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center;">Nama Jelas Dan Tanda Tangan</td>
        </tr>
    </table>
</div>
</body>
</html>
