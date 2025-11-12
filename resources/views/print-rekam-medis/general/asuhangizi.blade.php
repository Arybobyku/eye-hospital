<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>REKAM MEDIS GENERAL - ASUHAN GIZI</title>
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
		RM 3.3/AG/22
	</div>
	@include('print-rekam-medis.partials.header')
    <table style="width: 100%;  border: 1px solid black;" cellpadding="0" cellspacing="0" >
        <tr>
            <td style="font-weight: bold; text-align: center; padding: 5px; border-bottom: 1px solid black;">
            ASUHAN GIZI
            </td>
        </tr>
        <tr>
            <td style="padding-bottom: 20px; padding-left: 8px;">Diagnose Medis :</td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: center; padding: 5px; background-color: #A9A9A9; border-bottom: 1px solid black; border-top: 1px solid black;">
            ASESMEN/PENGKAJIAN GIZI 
            </td>
        </tr>
        <tr>
            <td style="padding-bottom: 30px; padding-left: 5px;"> <b>Antropometri</b>  </td>
        </tr>
        <tr>
            <td >
                <table style="width: 60%;">
                    <tr>
                        <td style=" width:30%">BB : __________ Kg</td>
                        <td style=" width:30%">IMT : __________ kg/m2</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style=" border-bottom: 1px solid black;">               
                <table style="width: 60%;">
                    <tr>
                        <td style="padding-bottom:10px; width: 30%;">TB : __________ Kg</td>
                        <td style="padding-bottom:10px; width: 30%;">Tinggi Lutut : __________ cm</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom: 30px; border-bottom: 1px solid black; padding-left: 5px;> Antropometri"> <b>Biokimia</b>  </td>
        </tr>
        <tr>
            <td style="padding-bottom: 30px; border-bottom: 1px solid black; padding-left: 5px;> Antropometri"> <b>Klinik/Fisik </b>  </td>
        </tr>
        <tr>
            <td style="padding-bottom: 20px;  padding-left: 5px;> Antropometri"> <b>Riwayat Gizi </b>  </td>
        </tr>
        <tr>
            <td style="padding-left: 5px;">Pola Makan   : </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td style="padding-left: 5px; padding-bottom:10px;">Asupan Gizi   : </td>
        </tr>
        <tr>
            <td style="padding-bottom: 2px; border-bottom: 1px solid black;  padding-left: 5px;"> <b>Riwayat Personal</b>  </td>
        </tr>
        <tr>
            <td style="padding-bottom: 20px; border-bottom: 1px solid black;  padding-left: 5px;"> <br></td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: center; padding: 5px; background-color: #A9A9A9; border-bottom: 1px solid black; border-top: 1px solid black;">
            DIAGNOSIS/MASALAH GIZI  
            </td>
        </tr>
        <tr>
            <td style="padding-bottom: 20px; border-bottom: 1px solid black;  padding-left: 5px;"> <br></td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: center; padding: 5px; background-color: #A9A9A9; border-bottom: 1px solid black; border-top: 1px solid black;">
            INTERVENSI GIZI 
            </td>
        </tr>
        <tr>
            <td style="padding-bottom: 20px; border-bottom: 1px solid black;  padding-left: 5px;"> <br></td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: center; padding: 5px; background-color: #A9A9A9; border-bottom: 1px solid black; border-top: 1px solid black;">
            RENCANA MONITORING DAN EVALUASI
            </td>
        </tr>
        <tr>
            <td style="text-align: right; padding-top: 60px; padding-right: 2%;">Tgl :……………………jam : ………………WIB</td>
        </tr>
        <tr>
            <th style="text-align: right; padding-right: 20%; padding-bottom: 60px;">Ahli Gizi,</th>
        </tr>
        <tr>
            <td style="text-align: right; padding-right: 2%;">.........................................................................</td>
        </tr>
        <tr>
            <td style="text-align: right; padding-right: 14%; padding-bottom: 20px;"><i>Nama & Tanda Tangan</i></td>
        </tr>
    </table>
</div>
</body>
</html>
