<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>REKAM MEDIS GENERAL - FORMULIR REAKSI TRANSFUSI DARAH</title>
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
		RM 6.2/FRTD/22
	</div>
	@include('print-rekam-medis.partials.header')
    <table style="width: 100%;  border: 1px solid black;" cellpadding="0" cellspacing="0" >
        <tr>
            <td style="font-weight: bold; text-align: center; padding: 5px; border-bottom: 1px solid black;">
            FORMULIR REAKSI TRANSFUSI DARAH
            </td>
        </tr>
    </table>
    <table style="width: 100%;  border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;" cellpadding="0" cellspacing="0" >
        <tr>
            <td colspan="3" style="padding-left:8px;">Dokter Pengirim / Referring Doctor</td>
            <td colspan="2" style="border-left:1px solid black; padding-left:5px;">Rawat Inap / Impatient</td>
            <td colspan="2" style="padding-left:10px;">Rawat Jalan / Outpatient</td>
        </tr>
        <tr>
            <td colspan="3" style="padding-top: 36px; padding-left:8px;">Tgl/Date</td>
            <td colspan="4" style="border-left:1px solid black;"><br></td>
        </tr>
        <tr>
            <td colspan="7" style="border-top:1px solid black; font-size:15px; padding-left:8px;">Untuk advis diagnosa dan terapi, manajemen dan sangkaan akan reaksi transfusi, hubungi dokter jaga ruangan</td>
        </tr>
        <tr>
            <td  colspan="7" style="border-top:1px solid black;">
                <table style="width: 100%;">        
                    <tr>
                        <td style="width: 50%; padding-left:8px;">Instalansi : ....................................................................</td>
                        <td style="width: 50%;">Tanggal : .......................................................................</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-left:8px;">Diagnosa Klinis :...................................................................................................................................................</td>
                    </tr>
                    <tr>
                        <td style="width: 50%; padding-left:8px;" >Produk Darah : ............................................................</td>
                        <td style="width: 50%;">Waktu Permintaan : ......................................................</td>
                    </tr>
                    <tr> 
                        <td style="width: 50%; padding-left:8px;" >No. Kantong : ..............................................................</td>
                        <td style="width: 50%;">Vol. Transfusi : ........................................................M1</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="7" style="border-top:1px solid black;">
                <table style="width: 100%;">
                    <tr>
                        <td colspan="2" style="padding-left:8px;"><b>Clerical Check :</b></td>
                        <td colspan="2"><b>Temperatur dalam 24 jam selama transfuse :</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td>FEBRIS</td>
                        <td>AFEBRIS (< 38 &deg; C)</td>
                    </tr>
                    <tr>
                        <td style="padding-left:8px;">Pasien ID</td>
                        <td colspan="3">Ya/Tidak</td>
                    </tr>
                    <tr>
                        <td style="padding-left:8px;">Bag Darah</td>
                        <td colspan="3">Ya/Tidak</td>
                    </tr>
                    <tr>
                        <td style="padding-left:8px;">Rekord Transfusi Darah</td>
                        <td colspan="3">Ya/Tidak</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="border-top:1px solid black;">
            <td colspan="2" style=" padding-left:8px;"><b>Vital Sign</b></td>
            <td style="border:1px solid black; text-align:center;"><b>Waktu</b></td>
            <td style="border:1px solid black; text-align:center;"><b>Temperatur</b></td>
            <td style="border:1px solid black; text-align:center;"><b>H.R</b></td>
            <td style="border:1px solid black; text-align:center;"><b>B.P</b></td>
            <td style="border:1px solid black; text-align:center;"><b>Pulse</b></td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 20px;">Pre reaksi alergi</td>
            <td style="border:1px solid black;"></td>
            <td style="border:1px solid black;"></td>
            <td style="border:1px solid black;"></td>
            <td style="border:1px solid black;"></td>
            <td style="border:1px solid black;"></td>
        </tr>
        <tr>                        
            <td colspan="2" style="padding-left: 20px;">Waktu terjadi reaksi</td>
            <td style="border:1px solid black;"></td>
            <td style="border:1px solid black;"></td>
            <td style="border:1px solid black;"></td>
            <td style="border:1px solid black;"></td>
            <td style="border:1px solid black;"></td>
        </tr>
        <tr>
            <td colspan="7" style="border-top:1px solid black; padding-left:8px;"><b>Obat premedikasi</b></td>
        </tr>
        <tr>
            <td style="border-top:1px solid black; text-align:center;">a.	Antipiretik</td>
            <td colspan="2" style="border-left:1px solid black; border-top:1px solid black; text-align:center;">b.	Antihistamin</td>            
            <td colspan="2" style="border-left:1px solid black; border-top:1px solid black; text-align:center;">c.	Steroid</td>
            <td colspan="2" style="border-left:1px solid black; border-top:1px solid black; text-align:center;">d.	Diuretik</td>
        </tr>
        <tr>
            <td colspan="7" style="border-top:1px solid black; padding-left:8px;"><b>Tanda dan Gejala</b></td>
        </tr>
        <tr>
            <td colspan="7">
                <table style="width: 100%;">
                    <tr>
                        <td style="padding-left: 8px;">Demam</td>
                        <td ><input type="checkbox"></td>
                        <td>Pusing</td>
                        <td ><input type="checkbox"></td>
                        <td>Kejang</td>
                        <td ><input type="checkbox"></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 8px;">Sesak Nafas</td>
                        <td ><input type="checkbox"></td>
                        <td>Menggigil</td>
                        <td ><input type="checkbox"></td>
                        <td>Sakit Kepala</td>
                        <td ><input type="checkbox"></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 8px;">Nyeri Dada</td>
                        <td ><input type="checkbox"></td>
                        <td >Gatal – gatal</td>
                        <td ><input type="checkbox"></td>
                        <td>Mual – mual</td>
                        <td ><input type="checkbox"></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 8px;">Lower back pain </td>
                        <td ><input type="checkbox"></td>
                        <td>Bentol – bentol</td>
                        <td ><input type="checkbox"></td>
                        <td>Muntah</td>
                        <td ><input type="checkbox"></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 8px;">Lain - lain </td>
                        <td ><input type="checkbox"></td>
                        <td>Urine Gelap</td>
                        <td ><input type="checkbox"></td>
                        <td>Pendarahan dari luka atau IV</td>
                        <td><input type="checkbox"></td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td colspan="7" style="border-top:1px solid black; padding-left: 8px;"><b>Pemberian darah yang diberikan dibawah 12 jam</b></td>
        </tr>
        <tr>
          <td style="border:1px solid black; text-align:center;" rowspan="2">Donor Unit</td>
          <td style="border:1px solid black; text-align:center;" rowspan="2">Tipe Darah</td>
          <td style="border:1px solid black; text-align:center;" rowspan="2">Tipe Darah</td>
          <td style="border:1px solid black; text-align:center;" colspan="2">Waktu</td>
          <td style="border:1px solid black; text-align:center;" rowspan="2">Vol. darah yang masuk</td>
          <td style="border:1px solid black; text-align:center;" rowspan="2">Reaksi <br>Ya/Tidak</td>
        </tr>
        <tr>
          <td style="border:1px solid black; text-align:center;">Mulai</td>
          <td style="border:1px solid black; text-align:center;">Stop</td>
        </tr>
        <tr>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
        </tr>
        <tr>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
        </tr>
        <tr>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
            <td style="border:1px solid black; text-align:center;"><br></td>
        </tr>
        <tr>
            <td colspan="7" style="padding-left: 8px;"> Dokter Pengirim</td>
        </tr>
        <tr>
            <td style="padding-left: 8px;">Nama</td>
            <td colspan="2">: ............................................</td>
            <td style="width:1%;"></td>
            <td>Telp. HP</td>
            <td colspan="2">: ................................................</td>
        </tr>
        <tr>
            <td style="padding-left: 8px;">Sign</td>
            <td colspan="2">: ............................................</td>
            <td></td>
            <td>Tanggal</td>
            <td colspan="2">: ................................................</td>
        </tr>
        <tr>
            <td colspan="7" style="padding-top:2%; padding-left: 8px;">Pertimbangkan :</td>
        </tr>
        <tr>
            <td colspan="7" style="padding-left: 8px;">Indikasi transfusi darah jika Hb, 7 gr/dl </td>
        </tr>
        <tr>
            <td colspan="7" style="padding-left: 8px;">Akhir transfusi cukup sampai Hb ± 10 gr/dl</td>
        </tr>
    </table>
</div>
</body>
</html>
