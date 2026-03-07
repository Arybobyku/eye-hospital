<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Invoice</title>
    <style>
    @page { margin: 16px; }
    body { margin: 16px; }
        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }
    </style>
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;">
	<?php
		// SBK => Surat Balasan Konsul
		$msg = 'RSKM-PV/SBK-'.date('y').'/'.date('m').'/S-';
		$nomor = $surat->surat_ke;
		if ($nomor > 0 && $nomor < 10) { $msg .= '000'.$nomor; }
		else if ($nomor > 9 && $nomor < 100) { $msg .= '00'.$nomor; }
		else if ($nomor > 99 && $nomor < 1000) { $msg .= '0'.$nomor; }
		else if ($nomor > 999 && $nomor < 10000) { $msg .= ''.$nomor; }
		echo $msg;
	?>	
</div>
<?php $fullpath = storage_path('app/public/header.png');  ?>
<div class="wrap">
	<table style="width: 100%; text-align: center" border="0">
		<thead>
			<tr>
				<th>
					<img 
					style="width: 100px; position: relative; left: -300px;"
					src="data:image/png;base64,
					<?php echo base64_encode(file_get_contents($fullpath)); ?>"
					/>
					<p style="margin-top: -85px; margin-left: -260px">
						<span style="font-size: 14px; position: relative; left: -10px; top: -3px">RUMAH SAKIT KHUSUS MATA</span><br />
						<span style="font-size: 35px; position: relative; left: 10px; top: -8px; color: #18365d">PRIMA VISION</span><br />
						<span style="font-size: 14px; position: relative; left: -10px; top: -13px">VISION FOR THE NATION</span>
					</p>
				</th>
			</tr>
			<tr>
				<th>
					<div style="width: 83%; font-size: 9.5pt; padding-left: 19%; text-align:left; position: relative; top: -32px">
						<span style="text-decoration: underline">PRIMA VISION EYE HOSPITAL - 24 HOURS EYE-ACCIDENT AND EMERGENCY UNIT</span><br />
						<span style="text-transform: uppercase;">Jalan Pabrik Tenun No. 51-53. Medan Petisah. 20118. Sumatera Utara. Indonesia</span><br />
						<table style="width: 100%">
							<tr>
								<td>HOSPITAL HOTLINE</td>
								<td style="width: 55%">: (+6261) 805 14 888</td>
							</tr>
							<tr>
								<td>24 HOURS EMERGENCY HOTLINE</td>
								<td>: 0822 7755 5151</td>
							</tr>
							<tr>
								<td>EMAIL</td>
								<td>: rsprimavision@gmail.com</td>
							</tr>
						</table>
					</div>
				</th>
			</tr>
		</thead>
	</table>
	<div style="width: 100%; height: 1px; background: #353535; margin-top: -22px"></div>
	<div style="width: 100%; height: 1px; background: #353535; margin-top: 3px"></div>
	<br />

	
</div>
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
// 		if ($blnlahir > 0) { return $thnlahir . ' tahun ' . $blnlahir . ' bulan';  }
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
