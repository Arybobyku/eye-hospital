<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - SURAT BALASAN KONSUL</title>
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
<div style="position:fixed; right: 13px; bottom: 10px;">
</div>
<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  
<div class="wrap">
	<div style="width:100%; text-align:right; margin-bottom:5px">
		RM RSPMV RJ 10
	</div>
	@include('print-rekam-medis.partials.header')
	<br />

	<br>
	<div class="">
		<span class="left" style="font-weight: bold"> <u>SURAT BALASAN KONSUL</u>	</span>
		<span class="right">        {{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }} </span>

	</div>
	<br>

	<br>
	<br>
	
	<table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">Kepada Yang Terhormat/Dear Collegue <br>
			TS. PROF/DR {{ $data->tujuan_nama_dokter }} <br>
			<br>
			Di/In {{$data->tujuan_lokasi}}</td>
		</tr>
		<br>
		<br>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
			Bersama ini kami konsulkan pasien : <br>
			Herewith, we would like to refer following patient : <br>
			<br>
			</div>

			<br>
			
			<div>
			Bersama ini kami konsulkan pasien : <br>
			Herewith, we would like to refer following patient : <br>
			<br>
			<br>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px">
				Nama/Name : {{$data->pasien_nama}}<br>
				Umur/Age : {{$data->pasien_umur}}.	<br>
				Keluhan Utama/Chief Complaint :{{$data->keluhan_utama}}	<br>
				Diagnosa Sementara/Differential Diagnosis : {{$data->diagnosa}}. <br>
				Pengobatan & Tindakan yang telah diberikan / Medication & Treatments Given : 
				{{$data->hasil_konsul_tindakan}}
				<br>
			</td>
		</tr>
		<tr>
			<td style="width: 100%; padding-top: 15px">
				
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 10px; text-align: justify"> Atas bantuannya, kami ucapkan banyak terima kasih <br>
			Really appreciate to your assistance. Thank you in advanced and we are looking forward to receiving 
			your report.
			</div>
		<br>
		<br>
			<div>
				Hormat kami/ With Regards, <br>
				Dokter Penanggung Jawab / Attending Doctor	<br>
				<br>
				  <img src="{{ $data->ttd_dokter }}" alt="Base64 Image" width="200px">
				<br>
				({{$data->nama_dokter_konsultan}})
			</td>
		</tr>
	</table>
</div>
</body>
</html>
