<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Invoice</title>
    <style>
    @page { margin: 13px; }
    body { margin: 13px; }
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
		// SKS = Surat Keterangan Sakit
		$msg = 'RSKM-PV/SKS-'.date('y').'/'.date('m').'/S-';
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
	<div style="width: 100%; height: 1px; background: #353535;margin-top: -26px"></div>
	<br />

	<div style="width: 100%; text-align: center; margin-top: -14px; margin-bottom: 3px; font-weight: bold">
		SURAT KETERANGAN ISTIRAHAT/SAKIT
	</div>

	<div style="width: 100%; height: 1px; background: #353535;"></div>
	<br />

	<table style="width: 100%; margin-top: 5px" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2" style="padding-bottom: 16px">
				<b>Yang bertanda tangan di bawah ini menerangkan bahwa : </b>
			</td>
		</tr>
		<tr>
			<td style="width: 25%; font-size: 12pt; line-height: 22px; padding-top: 3px">Nomor Surat</td>
			<td style="width: 75%; font-size: 12pt; line-height: 22px; padding-top: 3px">: </td>
		</tr>
		<tr>
			<td style="width: 25%; font-size: 12pt; line-height: 22px; padding-top: 3px">Nama</td>
			<td style="width: 75%; font-size: 12pt; line-height: 22px; padding-top: 3px">: {{ $registrasi->nama_pasien }}</td>
		</tr>
		<tr>
			<td style="width: 25%; font-size: 12pt; line-height: 22px; padding-top: 3px">No Rekam Medis</td>
			<td style="width: 75%; font-size: 12pt; line-height: 22px; padding-top: 3px">: {{ $registrasi->rekam_medis }}</td>
		</tr>
		<tr>
			<td style="width: 25%; font-size: 12pt; line-height: 22px; padding-top: 3px">Diagnosa</td>
			<td style="width: 75%; font-size: 12pt; line-height: 22px; padding-top: 3px">: {{ $surat->diagnosa }}</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-top: 16px">
				<?php 
					$mulai = explode("-",$surat->mulai_tanggal); 
					$akhir = explode("-",$surat->sampai_tanggal); 
				?>
				<span style="font-size: 12pt; line-height: 22px;">Sehubungan dengan penyakitnya, memerlukan istirahat selama <strong>{{ $surat->jumlah_hari }} ({{ terbilang($surat->jumlah_hari) }}) hari</strong>. 
				Terhitung dari tanggal <strong>{{ $mulai[2] }} {{ bulans($mulai[1]) }} {{ $mulai[0] }} sampai {{ $akhir[2] }} {{ bulans($akhir[1]) }} {{ $akhir[0] }}</strong>.
				</span>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-top: 10px">
				<span style="font-size: 12pt; line-height: 22px;">Demikianlah surat keterangan ini diperbuat untuk dapat dipergunakan seperlunya. <br />
				Atas bantuan yang sudah diberikan, kami ucapkan banyak terima kasih.</span>
			</td>
		</tr>
	</table>
	<br />

	<table style="width: 100%; margin-top: 10px; text-align: left" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td style="width: 70%"></td>
				<td style="width: 30%">
					Medan, {{ date('d') }} 
					<?php
						if (date('m') == '01') { echo 'Januari'; }
						else if (date('m') == '02') { echo 'Februari'; }
						else if (date('m') == '03') { echo 'Maret'; }
						else if (date('m') == '04') { echo 'April'; }
						else if (date('m') == '05') { echo 'Mei'; }
						else if (date('m') == '06') { echo 'Juni'; }
						else if (date('m') == '07') { echo 'Juli'; }
						else if (date('m') == '08') { echo 'Agustus'; }
						else if (date('m') == '09') { echo 'September'; }
						else if (date('m') == '10') { echo 'Oktober'; }
						else if (date('m') == '11') { echo 'November'; }
						else if (date('m') == '12') { echo 'Desember'; }
					?> 
					{{ date('Y') }}
				</td>
			</tr>
			<tr>
				<td style="width: 70%"></td>
				<td style="width: 30%">Dokter Pemeriksa</td>
			</tr>
			<tr>
				<td style="width: 70%"></td>
				<td style="width: 30%; height: 90px"></td>
			</tr>
			<tr>
				<td style="width: 70%;"></td>
				<td style="width: 30%"><strong>{{ $registrasi->nama_dokter }}</strong></td>
			</tr>
		</tbody>
	</table>
</div>
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
function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
?>
</body>
</html>
