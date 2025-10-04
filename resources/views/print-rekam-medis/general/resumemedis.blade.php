<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - Resume Medis</title>
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
		RM 3.5/RM/22
	</div>
	@include('print-rekam-medis.partials.header')
<table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
    <tr>
        <td style="font-weight: bold; text-align: center; padding: 7px;">
            RESUME MEDIS
        </td>
    </tr>
</table>
    <table style="width: 100%;  border: 1px solid black; cellpadding="0" cellspacing="0" >
      <tr>
        <td class="tablee" colspan="2">Tanggal Masuk : </td>
        <td class="tablee">Tanggal Keluar / Tanggal Meninggal : </td>
      </tr>
      <tr>
        <td class="tablee" colspan="2">Ruang Rawat terakhir : </td>
        <td class="tablee">Penanggung Pembayaran :</td>

      </tr>
      <tr>
        <td colspan="3" class="tablee"> Dokter Penanggung Jawab (DPJP)  :dr……………………………………………………… </td>
      </tr>
      <tr>
        <td colspan="3" class="tablee">
            <table>
                <tr>
                    <td>Rawat Tim Dokter :</td>
                    <td><input type="checkbox" ></td>
                    <td>Tidak</td>                    
                    <td><input type="checkbox" ></td>
                    <td>Ya, Oleh</td>
                    <td>1. dr..................................</td>
                    <td>3. dr..................................</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td>2. dr..................................</td>
                    <td>4. dr..................................</td>
                </tr>
            </table>
        </td>
      </tr>
      <tr >
        <td colspan="3" class="tablee">Alasan Dirawat : </td>
      </tr>
      <tr>
        <td colspan="3" class="tablee">Didiagnosa Masuk : </td>
      </tr>
      <tr>
        <td class="tablee">Didiagnosa Keluar (Diagnosa Utama) </td>
        <td class="tablee"></td>
        <td class="tablee">ICD</td>
      </tr>
      <tr>
        <td class="tablee">Diagnosis Sekunder</td>
        <td class="tablee">1. …………………………………………</td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee"></td>
        <td class="tablee">2. …………………………………………… </td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee"></td>
        <td class="tablee">3. …………………………………………… </td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee"></td>
        <td class="tablee">4. …………………………………………</td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee">Penyebab Kematian (Secara Klinis) </td>
        <td class="tablee"></td>
        <td class="tablee"></td>
      </tr>
      <tr >
        <td class="tablee">Pemertiksaan Fisik Yang penting </td>
        <td class="tablee"></td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee">Laboratorium Yang Penting </td>
        <td class="tablee"></td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee" colspan="2">Radiologi </td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee" colspan="2">Penunjang Lain</td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee">tindakan / Operasi</td>
        <td class="tablee"></td>
        <td class="tablee">ICD</td>
      </tr>
      <tr>
        <td class="tablee" colspan="2">Pengobatan Selama Dirawat</td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee" colspan>
            <table>
                <tr>
                    <td colspan="2">Kondisi Pulang </td>
                </tr>
                <tr>
                    <td><input type="checkbox" ></td>
                    <td>sembuh</td>
                </tr>
                <tr>
                    <td><input type="checkbox" ></td>
                    <td>Pindah RS </td>
                </tr>
                <tr>
                    <td><input type="checkbox" ></td>
                    <td>Pulang atas Permintaan Sendiri</td>
                </tr>
                <tr>
                    <td><input type="checkbox" ></td>
                    <td>Meninggal</td>
                </tr>
                <tr>
                    <td><input type="checkbox" ></td>
                    <td>Lain-Lain </td>
                </tr>
            </table>
        </td>
        <td class="tablee"></td>
        <td class="tablee">
            <table>
                <tr>
                    <td class="tablee">Instruksi dan Edukais Lanjutan (follow up)</td>
                </tr>
                <tr>
                    <td class="tablee">Kontrol Tanggal  :  </td>
                </tr>
                <tr>    
                    <td class="tablee">Diet   : </td>
                </tr>
                <tr>
                    <td class="tablee">Latihan   :</td>
                </tr>
                <tr>
                    <td class="tablee">Segera kembali ke rumah Sakit, langsung ke Gawat Darurat, bila terjadi :</td>
                </tr>
            </table>
        </td>
      </tr>
      <tr>
    <td colspan="3" class="tablee" style="font-weight:bold">Terapi Pulang</td>
      </tr>
      <tr>
        <td colspan="3">
            <Table>
                <tr>
                    <td class="tablee">Nama Obat </td>
                    <td class="tablee">Jumlah</td>
                    <td class="tablee">Dosis</td>
                    <td class="tablee">Frekuensi</td>
                    <td class="tablee">Cara Pemberian</td>
                    <td class="tablee">Nama Obat</td>
                    <td class="tablee">Jumlah</td>
                    <td class="tablee">Dosis</td>
                    <td class="tablee">Frekuensi</td>
                    <td class="tablee">Cara Pemberian</td>
                </tr>
                <tr>
                    <td class="tablee"><br></td>
                    <td class="tablee"><br></td>
                    <td class="tablee"><br></td>
                    <td class="tablee"><br></td>
                    <td class="tablee"><br></td>
                    <td class="tablee"><br></td>
                    <td class="tablee"><br></td>
                    <td class="tablee"><br></td>
                    <td class="tablee"><br></td>
                    <td class="tablee"><br></td>
                </tr>
            </Table>
        </td>
      </tr>
      <tr>
        <td colspan="3">Tanggal ...........</td>
      </tr>
      <tr>
        <td colspan="3" style="text-align: center;">Yang membuat <br><br><br><br></td> 
      </tr>    
      <tr>
        <td colspan="3" style="text-align: center;">………………………………………………….</td>
      </tr>
      <tr>
        <td colspan="3" style="text-align: center; ">Nama Jelas dan Tandatangan </td>
      </tr>
    </table>
    <div  style="text-align: right;">Page 2 to 2</div>
    <div><i>1. Lembar Asli Untuk arsip rekam Medis</i> </div>
    <div><i>2. Lembar Kedua Untuk Pasien</i> </div>
    <div><i>3. Lembar Ketiga Untuk Penjamin </i></div>
</div>
</body>
</html>
