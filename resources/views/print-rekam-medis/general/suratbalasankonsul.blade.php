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
		<span class="left" style="font-weight: bold"> <u>SURAT BALASAN KONSUL</u>
		<br>
		REPLY LETTER	
		</span>
		<span class="right"> ....................... <br>
		Tanggal/Date
		</span>

	</div>
	<br>

	<br>
	<br>
	
			<div>
			Kepada Yang Terhormat/Dear Collegue <br>
			TS. PROF/DR………………………………………. 
			<br>
			Di/In…………………………………………………
			<br>
			</div>

			<br>
			
			<div>
			Bersama ini kami konsulkan pasien : <br>
			Herewith, we would like to refer following patient : <br>
			<br>
			<br>
			</div>

		 <table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
              <tr>
    <td style="width: 525px; font-size: 12pt; line-height: 22px; padding-top: 5px">Nama/Name</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
	<tr>
    <td style="width: 525px; font-size: 12pt; line-height: 22px; padding-top: 5px">Umur/Age</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
	<tr>
    <td style="width: 525px; font-size: 12pt; line-height: 22px; padding-top: 5px">Keluhan Utama/Chief Complaint</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
	<tr>
    <td style="width: 525px; font-size: 12pt; line-height: 22px; padding-top: 5px">Diagnosa Sementara/Differential Diagnosis</td>
        <td> : </td>
        <td> ..................... </td>
        <br>
    </tr>
	<tr>
    <td style="width: 525px; font-size: 12pt;line-height: 22px; padding-top: 5px">Pengobatan & Tindakan yang telah diberikan / Medication & Treatments Given</td>
        <td> : </td>
        <td> ..........................</td>
        <br>
    </tr>
		 </table>

		 <br>

			<div> Atas bantuannya, kami ucapkan banyak terima kasih <br>
			Really appreciate to your assistance. Thank you in advanced and we are looking forward to receiving 
			your report.
			</div>
		<br>
		<br>
			<div>
				Hormat kami/ With Regards, <br>
				Dokter Penanggung Jawab / Attending Doctor	<br>
				<br>
				<br>
				<br>
				……………………………<br>
				Tanda tangan Dr & Stempel & Doctor’s Stamp
			</div>
</div>
</body>
</html>
