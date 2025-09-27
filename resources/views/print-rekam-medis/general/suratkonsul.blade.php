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



    </style>
    
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;">
</div>
<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  
<div class="wrap">
	<div style="width:100%; text-align:right; margin-bottom:5px">
		RM 8.5/SK/22
	</div>
	@include('print-rekam-medis.partials.header')
	<br />

	<br>
	<div class="">
		<span class="left" style="font-weight: bold"> <u>SURAT KONSUL</u>	</span>
		<span class="right"> ....................... </span>

	</div>

	<br>
	<br>

	<div class="">
		<span class="left" style="font-weight: bold">REFEAL LETTER</span>
		<span class="right">     Tanggal/Date </span>
	</div>

	<br>
	
	<table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">Kepada Yang Terhormat/Dear Collegue <br>
			TS. PROF/DR………………………………………. 
			<br>
			Di/In…………………………………………………</td>
		</tr>
		<br>
		<br>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
			Bersama ini kami konsulkan pasien : <br>
			Herewith, we would like to refer following patient : <br>
			<br>
			</td>
			<br>
			<br>
			<br>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px">
				Nama/Name : ………………………………………….……………… <br>
				Umur/Age : ………………………………………………………….	<br>
				Keluhan Utama/Chief Complaint :…………………………………………………………..	<br>
				Diagnosa Sementara/Differential Diagnosis : …………………………………………………………. <br>
				Pengobatan & Tindakan yang telah diberikan / Medication & Treatments Given : 
				……………………………………………………………………………………………………………
				……………………………………………………………………………………………………………
				<br>
			</td>
		</tr>
		<tr>
			<td style="width: 100%; padding-top: 15px">
				
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 10px; text-align: justify"> Atas bantuannya, kami ucapkan banyak terima kasih/ <br>
			Really appreciate to your assistance. Thank you in advanced and we are looking forward to receiving 
			your report.
			</td>
		</tr>
		<br>
		<br>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 10px">
				Hormat kami/ With Regards, <br>
				Dokter Penanggung Jawab / Attending Doctor	<br>
				<br>
				<br>
				<br>
				……………………………<br>
				Tanda tangan Dr & Stempel & Doctor’s Stamp
			</td>
		</tr>
	</table>
</div>
</body>
</html>
