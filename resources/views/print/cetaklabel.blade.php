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

				html {
					font-family: Arial, Helvetica, sans-serif;
				}

    </style>
</head>
<body>
<table class="depans">
    <tr>
        <td style="background: #434">
            <h2 style="position: absolute; top: 0px; left: 25px; right: 25px; color: #000; font-size: 20px; text-transform: uppercase">{{ $pasien->sebutan }} {{ $pasien->nama }}</h2>
						<table style="width: 100%; position: absolute; top: 60px; left: 25px; color: #000; font-size: 18px;">
							<tr>
								<td colspan="2" style="text-transform: capitalize; font-weight: bold; color: #000">{{ $pasien->jenis_kelamin }} - {{ $pasien->no_identitas }}</td>
							</tr>
							<tr>
								<td>TL/Umur</td>
								<td colspan="2" style=" font-weight: bold; color: #000">: 
									<?php
										$tglbayar = $pasien->tanggal_lahir;
										$data = explode('-',$tglbayar);
										$thn = $data[0]; $bln = $data[1]; $tgl = $data[2];
										if ($bln == '01') { $bln = 'Jan'; }
										else if ($bln == '02') { $bln = 'Febr'; }
										else if ($bln == '03') { $bln = 'Mar'; }
										else if ($bln == '04') { $bln = 'Apr'; }
										else if ($bln == '05') { $bln = 'Mei'; }
										else if ($bln == '06') { $bln = 'Jun'; }
										else if ($bln == '07') { $bln = 'Jul'; }
										else if ($bln == '08') { $bln = 'Agust'; }
										else if ($bln == '09') { $bln = 'Sep'; }
										else if ($bln == '10') { $bln = 'Okt'; }
										else if ($bln == '11') { $bln = 'Nov'; }
										else { $bln = 'Des'; }
									?>
									{{ $tgl }}-{{ $bln }}-{{ $thn }}/{{ umurs($pasien->tanggal_lahir) }}
								</td>
							</tr>
							<tr>
								<td>No. RM</td>
								<td style="text-transform: uppercase;  font-weight: bold; color: #000">: {{ $pasien->rekam_medis }}</td>
							</tr>
						</table>
            {{-- <h2 style="position: absolute; top: 165px; left: 40px; color: #000; font-size: 30px">Rekam Medis  : {{ $pasien->rekam_medis }}</h2>
            <h2 style="position: absolute; top: 199px; left: 40px; color: #000; font-size: 30px">
							<?php
								$tglbayar = $pasien->tanggal_lahir;
								$data = explode('-',$tglbayar);
								$thn = $data[0]; $bln = $data[1]; $tgl = $data[2];
								
							?>
							{{ $tgl }} {{ $bln }} {{ $thn }}
						</h2> --}}
            <h2 style="position: absolute; top: 228px; left: 40px; color: #000; font-size: 30px">{{ $pasien->jenis_kelamin }}</h2>
						{{-- <img src="{{ asset('img/kartu_depan.PNG') }}" class="img"/> --}}
        </td>
    </tr>
    {{-- <tr>
        <td style="background: #434">
            <img src="{{ asset('img/kartu_belakang.PNG') }}" class="img"/>
        </td>
    </tr> --}}
</table>

<?php

// function umurs($tanggal) {
// 	$tglnow = date('d');
// 	$blnnow = (int) date('m');
// 	$thnnow = (int) date('Y');

// 	$tgl = explode('-', $tanggal);
// 	$tgllahir = $tgl[2];
// 	$blnlahir = (int) $tgl[1];
// 	$thnlahir = (int) $tgl[0];

// 	$thnlahir = $thnnow - $thnlahir;
// 	if ($blnnow < $blnlahir) { $blnnow += 2 + 10; }
// 	$blnlahir = $blnnow - $blnlahir;
// 	if ($thnlahir >= 1) {
// 		if ($blnlahir > 0) { return $thnlahir . ' tahun';  }
// 		return $thnlahir . ' tahun'; 
// 	}
// 	return $blnlahir . ' bulan';
// }

function umurs($tanggal)
{
    $now = new DateTime();
    $lahir = new DateTime($tanggal);

    if ($lahir > $now) {
        return '0 bulan';
    }

    $diff = $now->diff($lahir);

    if ($diff->y >= 1) {
        if ($diff->m > 0) {
            return $diff->y . ' tahun ' . $diff->m . ' bulan';
        }
        return $diff->y . ' tahun';
    }

    return $diff->m . ' bulan';
}

?>
</body>
</html>
