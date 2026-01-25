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
		// SRK = Surat Resep Kacamata
		$msg = 'RSKM-PV/SRK-'.date('y').'/'.date('m').'/S-';
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
	<div style="width: 100%; height: 1px; background: #353535; margin-top: -26px"></div>
	<br />

	<div style="width: 100%; text-align: center; margin-top: -14px; margin-bottom: 3px; font-weight: bold">
		RESEP KACAMATA/SPECTACLES PRESCRIPTON
	</div>

	<div style="width: 100%; height: 1px; background: #353535;"></div>
	<br />

	<table style="width: 100%; margin-top: -10px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 50%">
				<table  style="width: 100%; border: none;" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border: none; padding: 2px 5px">Nama Lengkap</td>
						<td style="border: none; padding: 2px 5px">: {{ $registrasi->nama_pasien }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 5px">No. Rekam Medis</td>
						<td style="border: none; padding: 2px 5px">: {{ $registrasi->rekam_medis }}</td>
					</tr>
				</table>
			</td>
			<td style="width: 50%">
				<table style="width: 100%; border: none;" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border: none; padding: 2px 5px">Tanggal</td>
						<td style="border: none; padding: 2px 5px">: 
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
						</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 5px">&nbsp;</td>
						<td style="border: none; padding: 2px 5px">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br />

	<table style="width: 100%; margin-top: -10px; text-align:center" cellpadding="0" cellspacing="0">
		<tr>
			<td rowspan="2" style="border: 1px solid #595959; padding: 6px 5px; font-size: 12pt; line-height: 22px;">Kacamata</td>
			<td colspan="4" style="border: 1px solid #595959; padding: 6px 5px; font-size: 12pt; line-height: 22px;">Mata Kanan/Ocular Dextra</td>
			<td colspan="4" style="border: 1px solid #595959; padding: 6px 5px; font-size: 12pt; line-height: 22px;">Mata Kiri/Ocular Sinistra</td>
			<td rowspan="2" style="border: 1px solid #595959; padding: 6px 5px; font-size: 12pt; line-height: 22px;; width: 10%">Inter Pupillary Distance</td>
		</tr>
		<tr>
			<td style="border: 1px solid #595959; padding: 6px 5px; font-size: 12pt; line-height: 22px;">Spheris</td>
			<td style="border: 1px solid #595959; padding: 6px 5px; font-size: 12pt; line-height: 22px;">Cylindris</td>
			<td style="border: 1px solid #595959; padding: 6px 5px; font-size: 12pt; line-height: 22px;">Axis</td>
			<td style="border: 1px solid #595959; padding: 6px 5px; font-size: 12pt; line-height: 22px;">BCVA</td>
			<td style="border: 1px solid #595959; padding: 6px 5px; font-size: 12pt; line-height: 22px;">Spheris</td>
			<td style="border: 1px solid #595959; padding: 6px 5px; font-size: 12pt; line-height: 22px;">Cylindris</td>
			<td style="border: 1px solid #595959; padding: 6px 5px; font-size: 12pt; line-height: 22px;">Axis</td>
			<td style="border: 1px solid #595959; padding: 6px 5px; font-size: 12pt; line-height: 22px;">BCVA</td>
		</tr>
		<tr>
			<?php
				$bcva_dextra = explode(" ", $ro->ocular_dextra_bcva1);
				$bcva_dextra_c = '';
				$bcva_dextra_s = '';
				$bcva_dextra_x = '';
				if (count($bcva_dextra) == 1) { 
					$bcva_dextra_c = $bcva_dextra[0]; 
					$tmp = explode("-", $bcva_dextra_c);
					if (count($tmp) > 1) { $bcva_dextra_c = $tmp[1]; }
				}
				else if (count($bcva_dextra) == 2) { 
					$bcva_dextra_c = $bcva_dextra[0]; 
					$tmp = explode("-", $bcva_dextra_c);
					if (count($tmp) > 1) { $bcva_dextra_c = $tmp[1]; }

					$bcva_dextra_s = $bcva_dextra[1]; 
					$tmp = explode("-", $bcva_dextra_s);
					if (count($tmp) > 1) { $bcva_dextra_s = $tmp[1]; }
				}
				else if (count($bcva_dextra) == 3) { 
					$bcva_dextra_c = $bcva_dextra[0]; 
					$tmp = explode("-", $bcva_dextra_c);
					if (count($tmp) > 1) { $bcva_dextra_c = $tmp[1]; }

					$bcva_dextra_s = $bcva_dextra[1]; 
					$tmp = explode("-", $bcva_dextra_s);
					if (count($tmp) > 1) { $bcva_dextra_s = $tmp[1]; }

					$bcva_dextra_x = $bcva_dextra[2]; 
					$tmp = explode("-", $bcva_dextra_x);
					if (count($tmp) > 1) { $bcva_dextra_x = $tmp[1]; }
				}

				$bcva_sinistra = explode(" ", $ro->ocular_sinistra_bcva1);
				$bcva_sinistra_c = '';
				$bcva_sinistra_s = '';
				$bcva_sinistra_x = '';
				if (count($bcva_sinistra) == 1) { 
					$bcva_sinistra_c = $bcva_sinistra[0]; 
					$tmp = explode("-", $bcva_sinistra_c);
					if (count($tmp) > 1) { $bcva_sinistra_c = $tmp[1]; }
				}
				else if (count($bcva_sinistra) == 2) { 
					$bcva_sinistra_c = $bcva_sinistra[0]; 
					$tmp = explode("-", $bcva_sinistra_c);
					if (count($tmp) > 1) { $bcva_sinistra_c = $tmp[1]; }

					$bcva_sinistra_s = $bcva_sinistra[1]; 
					$tmp = explode("-", $bcva_sinistra_s);
					if (count($tmp) > 1) { $bcva_sinistra_s = $tmp[1]; }
				}
				else if (count($bcva_sinistra) == 3) { 
					$bcva_sinistra_c = $bcva_sinistra[0]; 
					$tmp = explode("-", $bcva_sinistra_c);
					if (count($tmp) > 1) { $bcva_sinistra_c = $tmp[1]; }

					$bcva_sinistra_s = $bcva_sinistra[1]; 
					$tmp = explode("-", $bcva_sinistra_s);
					if (count($tmp) > 1) { $bcva_sinistra_s = $tmp[1]; }

					$bcva_sinistra_x = $bcva_sinistra[2]; 
					$tmp = explode("-", $bcva_sinistra_x);
					if (count($tmp) > 1) { $bcva_sinistra_x = $tmp[1]; }
				}
			?>
			<td style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;">Jauh</td>
			<td style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong>{{ $bcva_dextra_s }}</strong></td>
			<td style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong>{{ $bcva_dextra_c }}</strong></td>
			<td style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong>{{ $bcva_dextra_x }}</strong></td>
			<td rowspan="2" style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong><strong>{{ $ro->ocular_dextra_bcva2 }}</strong></strong></td>
			<td style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong>{{ $bcva_sinistra_s }}</strong></td>
			<td style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong>{{ $bcva_sinistra_c }}</strong></td>
			<td style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong>{{ $bcva_sinistra_x }}</strong></td>
			<td rowspan="2" style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong>{{ $ro->ocular_sinistra_bcva2 }}</strong></td>
			<td rowspan="2" style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong>{{ $ro->ocular_dextra_pd }}</strong></td>
		</tr>
		<tr>
			<td style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;">Dekat</td>
			<td colspan="3" style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong>{{ $ro->ocular_dextra_add }}</strong></td>
			{{-- <td style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong></strong></td> --}}
			<td colspan="3" style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong>{{ $ro->ocular_sinistra_add }}</strong></td>
			{{-- <td style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong></strong></td> --}}
			{{-- <td style="border: 1px solid #595959; padding: 7px 5px; font-size: 12pt; line-height: 22px;"><strong>{{ $ro->ocular_dextra_pd }}</strong></td> --}}
		</tr>
	</table>
	<br />

	@if ($surat->m1 == 'ada' || $surat->m2 == 'ada')
	<table style="width: 100%; margin-top: -10px; text-align:left" cellpadding="0" cellspacing="0">
		
		<tr>
			<td style=" font-size: 14pt; line-height: 22px;"><b>Instruksi Khusus</b></td>
		</tr>
		<tr>
			<td style=" font-size: 12pt; line-height: 22px;">Mohon</td>
		</tr>
		<tr>
			<td style="padding-top: 10px;">
				@if ($surat->m1 == 'ada')
				<div style="position: relative; top: 3px; margin-right: 10px; width: 16px; border-radius: 100%; height: 16px; background: #414868; float: left; font-size: 12pt; line-height: 25px;"></div> Ulangi pemeriksaan refraksi untuk mendapatkan tajam penglihatan terbaik dan ternyaman <br />
				@endif

				@if ($surat->m2 == 'ada')
					<div style="position: relative; top: 3px; margin-right: 10px; width: 16px; border-radius: 100%; height: 16px; background: #414868; float: left; font-size: 12pt; line-height: 25px;"></div> Resepkan kacamata sesuai dengan refraksi <br />
				@endif
			</td>
		</tr>
	</table>
	<br />
	@endif

	<table style="width: 100%; margin-top: 5px; text-align:left" cellpadding="0" cellspacing="0">
		<tr>
			<td style=" font-size: 12pt; line-height: 22px; width: 30%">
				@if ($surat->r1 == 'ada' || $surat->r2 == 'ada' || $surat->r3 == 'ada' || $surat->r4 == 'ada')
					Resep Buat/Prescription for:
				@else 
					&nbsp;
				@endif
			</td>
			<td style=" font-size: 12pt; line-height: 22px; width: 40%">&nbsp;</td>
			<td style=" font-size: 12pt; line-height: 22px; width: 30%">Medan {{ date('d') }} {{ bulans(date('m')) }} {{ date('Y') }}</td>
		</tr>
		<tr>
			<td style="padding-top: 10px;" valign="top">
				@if ($surat->r1 == 'ada')
					<div style="position: relative; top: 3px; margin-right: 10px; width: 16px; border-radius: 100%; height: 16px; background: #414868; float: left; font-size: 12pt; line-height: 25px;"></div> Monofocal <br />
				@endif

				@if($surat->r2 == 'ada')
					<div style="position: relative; top: 3px; margin-right: 10px; width: 16px; border-radius: 100%; height: 16px; background: #414868; float: left; font-size: 12pt; line-height: 25px;"></div> Bifocal/Progressive <br />
				@endif
				
				@if($surat->r3 == 'ada')
				<div style="position: relative; top: 3px; margin-right: 10px; width: 16px; border-radius: 100%; height: 16px; background: #414868; float: left; font-size: 12pt; line-height: 25px;"></div> Contact Lens <br />
				@endif

				@if($surat->r4 == 'ada')
					<div style="position: relative; top: 3px; margin-right: 10px; width: 16px; border-radius: 100%; height: 16px; background: #414868; float: left; font-size: 12pt; line-height: 25px;"></div> Transitional<br />
				@endif
			</td>
			<td>&nbsp;</td>
			<td>
				<br /><br /><br /><br /><br />
				<span style="font-size: 12pt; line-height: 22px; text-decoration: underline"><strong>{{ $registrasi->nama_dokter }}</strong></span><br />
				<span style="font-size: 12pt; line-height: 22px;">Dokter yang menangani</span>
			</td>
		</tr>
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

?>
</body>
</html>
