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
	{{-- <?php
		// SKP = Surat Konsul Pasien
		// $msg = 'RSKM-PV/SKP-'.date('y').'/'.date('m').'/S-';
		// $nomor = $surat->surat_ke;
		// if ($nomor > 0 && $nomor < 10) { $msg .= '000'.$nomor; }
		// else if ($nomor > 9 && $nomor < 100) { $msg .= '00'.$nomor; }
		// else if ($nomor > 99 && $nomor < 1000) { $msg .= '0'.$nomor; }
		// else if ($nomor > 999 && $nomor < 10000) { $msg .= ''.$nomor; }
		// echo $msg;
	?>	 --}}
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

	<table style="width: 100%; margin-top: 10px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 65%"></td>
			<td style="width: 35%" align="right" valign="top">{{ date('d') }} {{ bulans(date('m')) }} {{ date('Y') }} {{ date('H:i:s') }}</td>
		</tr>
	</table>

	<h3>Identitas Pasien</h3>

	<table style="width: 100%; margin-top: 16px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">No. Rekam Medik</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $registrasi->rekam_medis }}</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">No. Identitas</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $pasien->jenis_identitas }}/{{ $pasien->no_identitas }}</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Nama Lengkap</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $registrasi->nama_pasien }}</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Tempat/Tanggal Lahir</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $pasien->tempat_lahir }}/{{ tglse($pasien->tanggal_lahir) }}</td>
		</tr>

		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Alamat Lengkap</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $pasien->alamat }}</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Kelurahan</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $pasien->nama_kelurahan }}</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Kecamatan</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $pasien->nama_kecamatan }}</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Kota/Kabupaten</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $pasien->nama_kab_kota }}</td>
		</tr>

		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">No Telepon/HP</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $pasien->no_handphone }}</td>
		</tr>

		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Pendidikan Terakhir</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $pasien->pendidikan_terakhir }}</td>
		</tr>

		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Pekerjaan</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $pasien->pekerjaan }}</td>
		</tr>

		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Agama</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $pasien->agama }}</td>
		</tr>

		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Status Perkawinan</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $pasien->status_pernikahan }}</td>
		</tr>
		
	</table>

	<h3>Identitas Penanggung Jawab Pasien</h3>

	<table style="width: 100%; margin-top: 16px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Nama</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: 
				@if ($penanggungjawab)
					{{ $penanggungjawab->nama }}
				@else
					-
				@endif
			</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Hubungan Dengan Pasien</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: 
				@if ($penanggungjawab)
					{{ $penanggungjawab->hubungan }}
				@else
					-
				@endif
			</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Alamat Lengkap</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: 
				@if ($penanggungjawab)
					{{ $penanggungjawab->alamat }}
				@else
					-
				@endif
			</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">No Identitas</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: 
				@if ($penanggungjawab)
					{{ $penanggungjawab->jenis_identitas }}/{{ $penanggungjawab->no_identitas }}
				@else
					-
				@endif
			</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">No Telepon/HP</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: 
				@if ($penanggungjawab)
					{{ $penanggungjawab->no_handphone }}
				@else
					-
				@endif
			</td>
		</tr>
	</table>

	<h3>Metode Pendaftaran</h3>

	<table style="width: 100%; margin-top: 16px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Masuk Melalui</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: Pendaftaran Customer Service</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Cara Bayar</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: 
				{{ $registrasi->carabayar_nama }}
				@if ($registrasi->nama_asuransi != '' && $registrasi->nama_asuransi != 'Silahkan Pilih')
					 - {{ $registrasi->nama_asuransi }}
				@endif
			</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-top: 2px; font-size: 12pt; line-height: 22px;">Cara Masuk</td>
			<td style="width: 60%; padding-top: 2px; font-size: 12pt; line-height: 22px;">: {{ $registrasi->cara_masuk }}</td>
		</tr>
	</table>
	
</div>
<?php

function tglse($created) {

$tgl_ = explode('-',$created);
$thn = $tgl_[0]; $bln = $tgl_[1]; $tgl = $tgl_[2];

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

return $tgl . ' ' . $bln . ' ' . $thn . ' ';
}

function umurs($tanggal) {
	$tglnow = date('d');
	$blnnow = (int) date('m');
	$thnnow = (int) date('Y');

	$tgl = explode('-', $tanggal);
	$tgllahir = $tgl[2];
	$blnlahir = (int) $tgl[1];
	$thnlahir = (int) $tgl[0];

	$thnlahir = $thnnow - $thnlahir;
	if ($blnnow < $blnlahir) { $blnnow += 2 + 10; }
	$blnlahir = $blnnow - $blnlahir;
	if ($thnlahir >= 1) {
		if ($blnlahir > 0) { return $thnlahir . ' tahun ' . $blnlahir . ' bulan';  }
		return $thnlahir . ' tahun'; 
	}
	return $blnlahir . ' bulan';
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
