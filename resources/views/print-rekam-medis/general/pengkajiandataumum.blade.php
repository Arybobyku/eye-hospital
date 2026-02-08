<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - PENGKAJIAN DATA UMUM</title>
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



    </style>
    
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;"></div>

<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?> 
<div class="wrap">
	<div style="width:100%; text-align:right; margin-bottom:5px">
		RM PDU
	</div>
	@include('print-rekam-medis.partials.header')
	<br />

	<br>

       <div style="font-weight: bold; text-align:center"> 
        <u>PENGKAJIAN DATA UMUM PASIEN</u>
    </div>

		 <table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
                     <tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">No. Rekam Medis</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
              <tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">Nama</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
	<tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">NIK</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
	<tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">No. Telp/HP </td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
	<tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">Jenis Kelamin</td>
        <td style="margin-left= 300px"> : </td>
        <td> ..................... </td>
        <br>
    </tr>
	<tr>
    <td style="width: 300px; font-size: 12pt;line-height: 22px; padding-top: 5px">Tanggal Lahir</td>
        <td> : </td>
        <td> .....................</td>
        <br>
    </tr>
             <tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">Agama</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
             <tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">Pendidikan</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>

             <tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">Pekerjaan</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
             <tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">Alamat</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
             <tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">Status Perkawinan</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>

             <tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">Nama Suami/Istri</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
             <tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">NIK Suami/Istri</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
             <tr>
    <td style="width: 300px; font-size: 12pt; line-height: 22px; padding-top: 5px">Status Pembiayaan</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>


		 </table>

	
</body>
</html>