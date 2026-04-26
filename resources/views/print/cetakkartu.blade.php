<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cetak Kartu</title>
    <style>
        @page { margin-left: -4px; margin-top: -4px; margin-bottom: -14px}


        table, td, tr {
            margin: 0 !important;
            padding: 0 !important;
        }

    </style>
</head>
<body>
<table class="depans">
    <tr>
        <td style="background: #434">
            <h2 style="position: absolute; top: 110px; left: 40px; color: #000; font-size: 30px; text-transform: uppercase">{{ $pasien->nama }}</h2>
            <h2 style="position: absolute; top: 165px; left: 40px; color: #000; font-size: 30px">{{ $pasien->rekam_medis }}</h2>
            <h2 style="position: absolute; top: 199px; left: 40px; color: #000; font-size: 30px">
							<?php
								$tglbayar = $pasien->tanggal_lahir;
								$data = explode('-',$tglbayar);
								$thn = $data[0]; $bln = $data[1]; $tgl = $data[2];
								if ($bln == '01') { $bln = 'Januari'; }
								else if ($bln == '02') { $bln = 'Februari'; }
								else if ($bln == '03') { $bln = 'Maret'; }
								else if ($bln == '04') { $bln = 'April'; }
								else if ($bln == '05') { $bln = 'Mei'; }
								else if ($bln == '06') { $bln = 'Juni'; }
								else if ($bln == '07') { $bln = 'Juli'; }
								else if ($bln == '08') { $bln = 'Agustus'; }
								else if ($bln == '09') { $bln = 'September'; }
								else if ($bln == '10') { $bln = 'Oktober'; }
								else if ($bln == '11') { $bln = 'November'; }
								else { $bln = 'Desember'; }
							?>
							{{ $tgl }} {{ $bln }} {{ $thn }}
						</h2>
            <h2 style="position: absolute; top: 228px; left: 40px; color: #000; font-size: 30px">{{ $pasien->jenis_kelamin }}</h2>
            <h2 style="position: absolute; top: 170px; right: 20px; color: #000;">{!! DNS2D::getBarcodeHTML($pasien->rekam_medis, 'QRCODE', 5,5) !!}</h2>
						{{-- <img src="{{ asset('img/kartu_depan.PNG') }}" class="img"/> --}}
        </td>
    </tr>
    {{-- <tr>
        <td style="background: #434">
            <img src="{{ asset('img/kartu_belakang.PNG') }}" class="img"/>
        </td>
    </tr> --}}
</table>
</body>
</html>
