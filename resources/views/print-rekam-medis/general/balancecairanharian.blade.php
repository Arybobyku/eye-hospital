<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - BALANCE CAIRAN HARIAN</title>
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
		RM 3.1/BCH/22
	</div>
	@include('print-rekam-medis.partials.header')
    <table style="width: 100%;  border: 1px solid black; cellpadding="0" cellspacing="0" >
        <tr>
        <td colspan="11" style="font-weight: bold; text-align: center; padding: 7px;">
            BALANCE CAIRAN HARIAN
        </td>
    </tr>
        <tr>
          <td class="tablee" rowspan="3">TGL/JAM</td>
          <td class="tablee" colspan="6">INTAKE / MASUK</td>
          <td class="tablee" colspan="3">OUTPUT / KELUAR</td>
          <td class="tablee" rowspan="3">NAMA PERAWAT</td>
        </tr>
        <tr>
          <td class="tablee" colspan="3">INTRAVENOUS</td>
          <td class="tablee" colspan="3">Mulut / NGT</td>
          <td class="tablee" rowspan="2">Jenis</td>
          <td class="tablee" rowspan="2">Jumlah</td>
          <td class="tablee" rowspan="2">Total</td>
        </tr>
        <tr>
          <td class="tablee">Jenis Cairan </td>
          <td class="tablee">Jumlah</td>
          <td class="tablee">Total</td>
          <td class="tablee">Jenis Makanan</td>
          <td class="tablee">Jumlah</td>
          <td class="tablee">Total</td>
        </tr>
        <tr>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
        </tr>
        <tr>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
        </tr>
        <tr>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
        </tr>
        <tr>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
          <td class="tablee"></td>
        </tr>
    </table>
</div>
</body>
</html>
