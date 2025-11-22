<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - SURAT PERNYATAAN PASIEN UMUM</title>
    <style>
    @page { margin: 18px; }
    body { margin: 18px; }
        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }
	

		.left { display: inline-block; float: left; }
		.right { display: inline-block; float: right; margin-right: 65px;}

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
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme3.png');  ?>  
    <div class="wrap">
	    <div style="width:100%; text-align:right; margin-bottom:5px">RM 9.10/SPPU/22</div>
	    @include('print-rekam-medis.partials.header3')
        <div style="font-weight: bold; text-align: center; padding: 10px;">SURAT PERNYATAAN PENOLAKAN RUJUKAN</div>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td colspan="2" style="width: 100%;  padding-bottom: 10px;">Yang bertanda tangan di bawah ini:</td>
            </tr>
            <tr>
                <td style="width: 50%;">Tempat/Tgl Lahir</td>
                <td style="width: 50%;">: .................................................................................</td>
            </tr>
            <tr>
                <td style="width: 50%;">Alamat</td>
                <td style="width: 50%;">: .................................................................................</td>
            </tr>
            <tr>
                <td style="width: 50%;">Pekerjaan</td>
                <td style="width: 50%;">: .................................................................................</td>
            </tr>
            <tr>
                <td style="width: 50%;">No Telp/HP</td>
                <td style="width: 50%;">: .................................................................................</td>
            </tr>
            <tr>
                <td style="width: 50%;">Hubungan Keluarga Pasien</td>
                <td style="width: 50%;">: .................................................................................</td>
            </tr>
            <tr>
                <td colspan="2" style="padding-bottom: 10px; padding-top: 10px;">Bertindak untuk dan atas nama pasien:</td>
            </tr>
            <tr>
                <td style="width: 50%;">Nama</td>
                <td style="width: 50%;">: .................................................................................</td>
            </tr>
            <tr>
                <td style="width: 50%;">Tempat/Tgl Lahir</td>
                <td style="width: 50%;">: .................................................................................</td>
            </tr>
            <tr>
                <td style="width: 50%;">Alamat</td>
                <td style="width: 50%;">: .................................................................................</td>
            </tr>
            <tr>
                <td style="width: 50%;">No RM</td>
                <td style="width: 50%;">: .................................................................................</td>
            </tr>
            <tr>
                <td colspan="2">Dengan ini menyatakan bahwa</td>
            </tr>
            <tr>
                <td colspan="2">
                    <ol style="text-align: justify;">
                        <li style="Margin-bottom: 2x">Saya sudah mendapat penjelasan dan telah dianjurkan untuk memakai penjamin BPJS jikalau memiliki kartu BPJS dan sesuai dengan ketentuan yang berlaku.</li>
                        <li style="Margin-bottom: 2px">Bahwa pasien tersebut tidak memiliki dan atau tidak mau menggunakan fasilitas jaminan kepesertaan BPJS Kesehatan.</li>
                        <li style="Margin-bottom: 2px">Bahwa atas keinginan sendiri pasien tersebut diatas saya setuju dilakukan pemeriksaan, pengobatan, perawatan sebagai pasien umum setelah saya memahami perlunya dan  manfaat tindakan tersebut.</li>
                        <li style="Margin-bottom: 2px">Bahwa saya bertanggung jawab dan bersedia membayar sendiri, secara pribadi atas biaya pemeriksaan, pengobatan, tindakan, dan perawatan sebagai pasien umum.</li>
                        <li style="Margin-bottom: 2px">Bahwa apabila saya melakukan pengingkaran atas pernyataan poin 1 – 4, maka saya bersedia dituntut secara hukum pasal penipuan/membuat pernyataan palsu.</li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: right; padding-right: 35%; padding-top: 60px;">Medan, .......... 20....</td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding-bottom: 20px;">Yang membuat pernyataan</td>
                            <td style="text-align: center; padding-bottom: 20px;">Saksi Pasien</td>
                            <td style="text-align: center; padding-bottom: 20px;">Saksi Petugas Rumah Sakit</td>
                        </tr>
                            <td style="text-align: center;">
                                <span style="border: 1px solid black; padding: 2px 8px; display: inline-block;">
                                    MATERAI<br>10.000
                                </span>
                            </td>
                            <td><br></td>
                            <td><br></td>

                        <tr>
                            <td style="text-align: center; padding-top: 20px;">(..................................)</td>
                            <td style="text-align: center; padding-top: 20px;">(..................................)</td>
                            <td style="text-align: center; padding-top: 20px;">(..................................)</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    @include('print-rekam-medis.partials.footer')
</body>
</html>
