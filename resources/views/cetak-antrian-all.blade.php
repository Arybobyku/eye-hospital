<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cetak Kartu</title>
    <style>
    @page { margin: 0; padding: 0 }
    * {
        font-size: 18px;
        font-family: Arial, Helvetica, san-serif;
    }
    .centered {
        text-align: center;
        align-content: center;
    }

    img {
        max-width: inherit;
        width: 135px;
    }

    @media print {
        .hidden-print, .hidden-print * {
            display: none !important;
        }
        .page-break { display: block; page-break-before: always; }
    }

    @media all {
        .page-break { display: none; }
    }

	table {
		width: 100%;
		height: auto;
		float:left;
		border: none;
	}

	table td {
		width: 100%;
		height: auto;
		text-align: center;
	}
	
    </style>
</head>
<body>
<table>
    <tr><td align="center"></td></tr>
    <tr>
			<td>
        <p class="centered" style="margin-top: -16px">
        <br>RS Khusus Mata Prima Vision</p>
      </td>
    </tr>
    <tr>
        <td><hr style="margin-left: 0px; margin-right:-20px; margin-top: -14px;" /></td>
    </tr>
    <tr>
      <td>
        {{-- <p class="centered" style="font-size: 18px; margin-top: 0px">{{ $jenis }}</p> --}}
        <h1 class="centered" style="font-size: 87px; line-height: 12px; margin-top:65px">
					<?php
					echo $noAntrian
					?>
				</h1>
        <p class="centered" style="margin-top: -40px; margin-bottom: 38px">No. Antrian</p>
        <p class="centered" style="margin-top: -30px; margin-bottom: 38px">
					@if ($jenis == 'Umum')
						Pasien umum
					@elseif ($jenis == 'Bpjs')
						Pasien BPJS Kesehatan
					@elseif ($jenis == '-')
						Farmasi (Racikan)
					@elseif ($jenis == 'nonracikan')
						Farmasi (Non Racikan)
					@endif
				</p>
      </td>
    </tr>
    <tr>
      <td><hr style="margin-left: 0px; margin-right:0px; margin-top: -24px;" /></td>
    </tr>
		<tr>
      <td>
				<p class="centered" style="margin-top: -16px; margin-bottom: 15px">
					{{ date('d') }} {{ bulans(date('m')) }} {{ date('Y') }} {{ date('H') }}:{{ date('i') }}
				</p>
			</td>
    </tr>
		<tr>
      <td><hr style="margin-left: 0px; margin-right:0px; margin-top: -7px;" /></td>
    </tr>
</table>
<?php
function bulans($bln) {
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
	else if ($bln == '12') { $bln = 'Desember'; }
	return $bln;
}
?>
</body>
</html>
