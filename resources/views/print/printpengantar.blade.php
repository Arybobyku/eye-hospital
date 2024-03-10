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
		// KTP = Kwitansi Tagihan Pasien
		// $msg = 'RSKM-PV/KTP-'.date('y').'/'.date('m').'/S-';
		// $nomor = $surat->surat_ke;
		// if ($nomor > 0 && $nomor < 10) { $msg .= '000'.$nomor; }
		// else if ($nomor > 9 && $nomor < 100) { $msg .= '00'.$nomor; }
		// else if ($nomor > 99 && $nomor < 1000) { $msg .= '0'.$nomor; }
		// else if ($nomor > 999 && $nomor < 10000) { $msg .= ''.$nomor; }
		// echo $msg;
	?>	
</div>
<?php $fullpath = storage_path('app/public/header.png');  ?>
<?php
$layananpasien = $layananpasien->sortBy('nama_layanan', SORT_REGULAR, false);
?>
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
								<td>: rsprimavision@gmail.com {{ gettype($layananpasien) }}</td>
							</tr>
						</table>
					</div>
				</th>
			</tr>
		</thead>
	</table>
	<div style="width: 100%; height: 1px; background: #353535; margin-top: -28px"></div>
	<br />

	<div style="width: 100%; text-align: right; margin-top: -5px; margin-bottom: 3px; font-size: 12pt">
		Medan, {{ tglse(date('Y-m-d')) }}
	</div>

	<br />

	<table  style="width: 100%;  margin-top: -42px; border: none; font-size: 12pt" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 15%">No </td>
			<td>: {{ $registrasi->kwitansi_claim }}</td>
		</tr>
		<tr>
			<td>Lamp </td>
			<td>: 1 (satu) Berkas</td>
		</tr>
		<tr>
			<td>Hal </td>
			<td>: Pengantar Pengiriman Tagihan Pasien</td>
		</tr>
	</table>

	<br />

	<table  style="width: 100%;  margin-top: -5px; border: none; font-size: 12pt" cellpadding="0" cellspacing="0">
		<tr>
			<td>Kepada Yth :</td>
		</tr>
		<tr>
			<td>Bapak/Ibu Pimpinan</td>
		</tr>
		<tr>
			<td>
				<?php
				if ($registrasi->carabayar_nama == 'Umum') {
					echo 'Pembayaran Pribadi';
				}
				else {
					$msg = $registrasi->carabayar_nama;
					if ($registrasi->nama_asuransi != '-' && $registrasi->nama_asuransi != '' && $registrasi->nama_asuransi != 'Silahkan Pilih') {
						$msg .= ' - '.$registrasi->nama_asuransi;
					}
					echo $msg;
				}
			?></td>
		</tr>
		<tr>
			<td>Di Tempat</td>
		</tr>
	</table>

	<br />

	<table  style="width: 100%;  margin-top: -5px; border: none; font-size: 12pt" cellpadding="0" cellspacing="0">
		<tr>
			<td>Dengan Hormat,</td>
		</tr>
		<tr>
			<td align="justify" style="padding: 4px 0"><span style="line-height: 23px">Melalui surat ini kami mengucapkan terima kasih atas kerjasama yang telah terjalin dengan baik antara Administrasi 
				<?php
				if ($registrasi->carabayar_nama == 'Umum') {
					echo 'Pembayaran Pribadi';
				}
				else {
					$msg = $registrasi->carabayar_nama;
					if ($registrasi->nama_asuransi != '-' && $registrasi->nama_asuransi != '' && $registrasi->nama_asuransi != 'Silahkan Pilih') {
						$msg .= ' - '.$registrasi->nama_asuransi;
					}
					echo $msg;
				}
			?> dengan RS Khusus Mata Prima Vision Medan dalam rangka pelayanan kesehatan {{ strtolower($registrasi->jenis) }}.</span></td>
		</tr>
		<tr>
			<td align="justify"><span style="line-height: 23px">Sehubungan  kami kirimkan kelengkapan Dokumen sebagai persyaratan Klaim kami kepada Adminitrasi 
				<?php
				if ($registrasi->carabayar_nama == 'Umum') {
					echo 'Pembayaran Pribadi';
				}
				else {
					$msg = $registrasi->carabayar_nama;
					if ($registrasi->nama_asuransi != '-' && $registrasi->nama_asuransi != '' && $registrasi->nama_asuransi != 'Silahkan Pilih') {
						$msg .= ' - '.$registrasi->nama_asuransi;
					}
					echo $msg;
				}
			?> dengan data pasien sebagai berikut :</span></td>
		</tr>
	</table>

	<br />


	<table  style="width: 100%;  margin-top: -8px; border: none; font-size: 12pt" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 20%; padding-top: 3px">Nama </td>
			<td style="padding-top: 3px">: {{ $pasien->sebutan }} {{ ucwords(strtolower($registrasi->nama_pasien)) }}</td>
		</tr>
		<tr>
			<td style="padding-top: 3px">Perusahaan </td>
			<td style="padding-top: 3px">: <?php
				if ($registrasi->carabayar_nama == 'Umum') {
					echo 'Pembayaran Pribadi';
				}
				else {
					$msg = $registrasi->carabayar_nama;
					if ($registrasi->nama_asuransi != '-' && $registrasi->nama_asuransi != '' && $registrasi->nama_asuransi != 'Silahkan Pilih') {
						$msg .= ' - '.$registrasi->nama_asuransi;
					}
					echo $msg;
				}
			?></td>
		</tr>
		<tr>
			<td style="padding-top: 3px">No. Kwitansi </td>
			<td style="padding-top: 3px">: {{ $registrasi->kwitansi_claim }}</td>
		</tr>
		<tr>
			<td style="padding-top: 3px">Tgl.Perawatan </td>
			<td style="padding-top: 3px">: {{ tglse($registrasi->tanggal) }}</td>
		</tr>
		<tr>
			<td style="padding-top: 3px">Total Tagihan </td>
			<td style="padding-top: 3px">: <?php $grandtotaltop = 0; ?>
				@foreach ($layananpasien as $item)
					<?php 
						// $grandtotaltop += $item->total; 
					?>
				@endforeach
				@if ($registrasi->panjar != '0')
					<?php 
						//$grandtotaltop = $grandtotaltop - $registrasi->panjar;
					?>
				@endif
				@if ($registrasi->cover_asuransi != '0')
					<?php 
						// $grandtotaltop = $grandtotaltop - $registrasi->cover_asuransi; 
					?>
				@endif
				@if ($registrasi->cover_asuransi != 0)
					<?php $grandtotaltop = $registrasi->cover_asuransi; ?>
				@endif

				@if ($registrasi->total_claim != 0)
					<?php $grandtotaltop = $registrasi->total_claim; ?> 
				@endif
				
				Rp. {{ number_format($grandtotaltop) }}
				@if ($registrasi->total_claim != 0)
				, - (Disc {{ $registrasi->diskon_claim }}%)
				@endif
			</td>
			@if ($registrasi->total_claim != 0)
			<tr>
				<td style="padding-top: 3px">After Discount </td>
				<td style="padding-top: 3px">: Rp. {{ number_format($registrasi->total_claim) }}</td>
			</tr>
			@endif
		</tr>
	</table>
			

	<table  style="width: 100%;  margin-top: 8px; border: none; font-size: 12pt" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2"><span style="line-height: 23px">Selanjutnya, kami kirimkan kelengkapan Dokumen sebagai Persyaratan Klaim kami kepada Administrasi 
				<?php
					if ($registrasi->carabayar_nama == 'Umum') {
						echo 'Pembayaran Pribadi';
					}
					else {
						$msg = $registrasi->carabayar_nama;
						if ($registrasi->nama_asuransi != '-' && $registrasi->nama_asuransi != '' && $registrasi->nama_asuransi != 'Silahkan Pilih') {
							$msg .= ' - '.$registrasi->nama_asuransi;
						}
						echo $msg;
					}
				?>, antara  lain : </span></td>
		</tr>
		<tr>
			<td style="width: 4%; padding-top: 8px">1. </td>
			<td style="padding-top: 8px">Surat jaminan Akhir dari <?php
				if ($registrasi->carabayar_nama == 'Umum') {
					echo 'Pembayaran Pribadi';
				}
				else {
					$msg = $registrasi->carabayar_nama;
					if ($registrasi->nama_asuransi != '-' && $registrasi->nama_asuransi != '' && $registrasi->nama_asuransi != 'Silahkan Pilih') {
						$msg .= ' - '.$registrasi->nama_asuransi;
					}
					echo $msg;
				}
			?></td>
		</tr>
		<tr>
			<td style="width: 4%; padding-top: 2px">2. </td>
			<td style="padding-top: 2px">Kwitansi Asli yang dibubuhi materai	</td>
		</tr>
		<tr>
			<td style="width: 4%; padding-top: 2px">3. </td>
			<td style="padding-top: 2px">Perincian Asli Hasil perawatan & obat-obatan termasuk biaya dokter	</td>
		</tr>
		<tr>
			<td style="width: 4%; padding-top: 2px">4</td>
			<td style="padding-top: 2px">Perincian dan Penunjang diagnostic lainnya.</td>
		</tr>
		<tr>
			<td style="width: 4%; padding-top: 2px">5</td>
			<td style="padding-top: 2px">Asli Resume Medis	</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-top: 8px; text-align:justify">
				<span style="line-height: 23px;">Kami mohon kepada Bapak/Ibu, apabila telah melakukan pembayaran melalui rekening kami Bank BCA No.Rek : 7865579888 Cab. KCP TOMANG ELOK atas nama : PT. VISI INSAN INDONESIA PRIMA, kami harap agar dapat mengirimkan Bukti Pembayaran via Email : primavisionfinance@gmail.com ,  Up : Debora Solavide Simanjuntak</span>	
			</td>
		</tr>
		<tr>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2" style="padding-top: 8px;">
				Demikian kami sampaikan, atas kerjasama yang baik kami ucapkan Terimakasih.	
			</td>
		</tr>
	</table>

	<br />

	<table style="width: 100%; margin-top: -10px; text-align: left; font-size: 12pt" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 31%">&nbsp;</td>
			<td style="width: 31%">&nbsp;</td>
			<td style="width: 37%" align="center">
				<div style="padding-top: 4px">Bagian Claim</div>
				<br /><br /><br /><br />
				<span style="text-decoration: underline">
					<b>(Debora Solavide Simanjuntak, S.E)</b>
				</span>
			</td>
		</tr>
	</table>
</div>
<div style="position: absolute; left: 16px; bottom: 15px">Dicetak pada 
	@if ($registrasi->tanggal_bayar != '1990-01-01')
		<?php
			$tglbayar = date('Y-m-d');
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
	@else
		-
	@endif
	
	{{ date('H') }}:{{ date('i') }}</div>
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

	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "Minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}

?>
</body>
</html>
