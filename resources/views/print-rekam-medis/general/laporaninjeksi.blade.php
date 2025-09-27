<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.3</title>
    <style>
        @page {
            margin: 18px;
        }

        body {
            margin: 18px;
        }

        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }

        .fontsmall {
            font-size: 10;
        }
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $patimg = storage_path('app/public/images/PAT.png'); ?>
    
        <div class="wrap">
            <div style="width:100%; text-align:right; margin-bottom:5px">
                RM 8.8/LIAV/22
            </div>
            @include('print-rekam-medis.partials.header')

            <div style="font-weight: bold; text-align:center; margin-top:10px"> 
         <u>LAPORAN INJEKSI ANTI VEGA </u> 
    </div>
    <br>


        <div style="margin-top: 5px; float: right">
        <span> Tanggal Operasi: __________________ </span>
        </div>
        <br>
        <br>
            <table style="width: 100%; text-align: left; margin-top:10px; padding-top:10px" cellpadding="0" cellspacing="0">
        
                {{-- Tanggal --}}
                <tr style="border: 1px solid black; width:100%">
                    <table style="border-collapse: collapse; width:100%">
                        <tr>
                            <td style="border-right: 1px solid black; width:100%">
                                Mata:  OD <input type="checkbox" style="padding-left: 10px; padding-right:10px">   OS <input type="checkbox" style="padding-left: 10px; padding-right:10px">
                                
                            </td>
                            <td style="border-right: 1px solid black; width:100%; ">
                                Operator:       
                                <br> 
                            </td>
                            <td style="border-right: 1px solid black; width:100%">
                                Jam Operasi: 
                            </td>
                            <td style="width:100%">
                                Lama Operasi: 
                            </td>

                        </tr>
                    </table>

                    <tr style="border: 1px solid black; width:100%">
                    <table style="border-collapse: collapse; width:100%">
                        <tr>
                            <td style="border-right: 1px solid black; width:100%">
                                Diagnosa: 
                            </td>
                            <td style="width:100%">
                                Asisten: 
                            </td>

                        </tr>
                    </table>
                    </tr>

                    <tr style="border: 1px solid black; width:100%">
                    <table style="border-collapse: collapse; width:100%">
                        <tr>
                            <td style="border-right: 1px solid black; width:100%">
                                Jenis Operasi: 
                            </td>
                            <td style="border-right: 1px solid black; width:100%">
                                Anesthesia: 
                            </td>
                            <td style="width:100%">
                                Anesthesiologist: 
                            </td>

                        </tr>
                    </table>
                    </tr>

                    <br>
                    <br>

		<tr>
			<td style="width: 100%; font-size: 12pt;padding-top: 5px">
			1.Pasien berbaring dalam anestesi topical/  local/  umum <br>
            2.Dilakukan tindakan a & antiseptis menggunakan providone iodin <br>
            3.Dipasangkan eye drape <br>
            4.Dipasangkan blefarostat <br>
            5.Dilakukan pengukuran menggunakan caliper/ trocar dengan jarak 3,5 / 4 mm dari limbus  <br>
            Di kuadran superior  /  temporal 	<br>
            6.Dilakukan injeksi avastin  /  intravitreal sebanyak ……… ml <br> 
            7.Diteteskan antibiotik <br>
            8.Mata ditutup kassa & dop <br>
            9.Tindakan selesai 
            <br>
				<br>
               <br>
                <br>                       
            </table>

            <div style="margin-top: 5px; float: right">
        <span> Tanda Tangan DPJP / Dokter</span>
        <br>
        <br>
        <br>
        <br>
        <br>
        <span> (…………………………….)</span>
        </div>
</body>

</html>
