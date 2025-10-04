<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - CATATAN KEPERAWATAN</title>
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
  .tablee {
    border: 1px solid black;
    border-collapse: collapse;
    text-align: center;
    padding: 5px;
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
		RM 3.0/CP/22
	</div>
	@include('print-rekam-medis.partials.header')
<table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
    <tr>
        <td style="font-weight: bold; text-align: center; padding: 7px;">
            CATATAN KEPERAWATAN
        </td>
    </tr>
</table>
    <table style="width: 100%;  border: 1px solid black; cellpadding="0" cellspacing="0" >
      <tr>
        <td class="tablee" style="width: 20%; font-weight: bold;">TANGGAL</td>
        <td class="tablee" style="width: 20%; font-weight: bold;">JAM </td>
        <td class="tablee" style="width: 20%; font-weight: bold;">URAIAN</td>
        <td class="tablee" style="width: 20%; font-weight: bold;"> NAMA & PARAF</td>
      </tr>
      <tr>
        <td class="tablee"><br></td>
        <td class="tablee"><br></td>
        <td class="tablee"><br></td>
        <td class="tablee"><br></td>
      </tr>
        <tr>
        <td class="tablee"><br></td>
        <td class="tablee"><br></td>
        <td class="tablee"><br></td>
        <td class="tablee"><br></td>
      </tr>
        <tr>
        <td class="tablee"><br></td>
        <td class="tablee"><br></td>
        <td class="tablee"><br></td>
        <td class="tablee"><br></td>
      </tr>
    </table>
</div>
</body>
</html>
