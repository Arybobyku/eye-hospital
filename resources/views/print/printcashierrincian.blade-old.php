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
<!-- <div style="position:fixed; right: 13px; bottom: 10px;">
	<?php
		// RTP = Rincian Tagihan Pasien
		// $msg = 'RSKM-PV/RTP-'.date('y').'/'.date('m').'/S-';
		// $nomor = $surat->surat_ke;
		// if ($nomor > 0 && $nomor < 10) { $msg .= '000'.$nomor; }
		// else if ($nomor > 9 && $nomor < 100) { $msg .= '00'.$nomor; }
		// else if ($nomor > 99 && $nomor < 1000) { $msg .= '0'.$nomor; }
		// else if ($nomor > 999 && $nomor < 10000) { $msg .= ''.$nomor; }
		// echo $msg;
	?>	
</div> -->
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
	<div style="width: 100%; height: 1px; background: #353535; margin-top: -28px"></div>
	<br />

	<div style="width: 100%; text-align: center; margin-top: -14px; margin-bottom: 3px; font-weight: bold">
		RINCIAN TAGIHAN
	</div>

	<div style="width: 100%; height: 1px; background: #353535;"></div>
	<br />

	<table style="width: 100%; margin-top: -10px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 50%">
				<table  style="width: 100%; border: none;" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border: none; padding: 2px 5px">No Invoice</td>
						<td style="border: none; padding: 2px 5px">: INV{{ $registrasi->no_invoice }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 5px">Nama Lengkap</td>
						<td style="border: none; padding: 2px 5px">: {{ $registrasi->nama_pasien }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 5px">No. Rekam Medik</td>
						<td style="border: none; padding: 2px 5px">: {{ $registrasi->rekam_medis }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 5px">Nomor Registrasi</td>
						<td style="border: none; padding: 5px">: RG{{ $registrasi->nomor }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 5px">Tgl Pendaftaran</td>
						<td style="border: none; padding: 2px 5px">: 
							<?php
								$tglbayar = $registrasi->tanggal;
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
						<td style="border: none; padding: 2px 5px">Umur/Tgl.Lahir</td>
						<td style="border: none; padding: 2px 5px">: {{ umurs($pasien->tanggal_lahir) }}/{{ lahirs($pasien->tanggal_lahir) }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 5px">Alamat</td>
						<td style="border: none; padding: 2px 5px">: {{ $pasien->alamat }}</td>
					</tr>
					@if ($registrasi->nama_asuransi != '-')
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					@endif
				</table>
			</td>
			<td style="width: 50%">
				<table style="width: 100%; border: none;" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border: none; padding: 2px 5px">Dokter yang menangani</td>
						<td style="border: none; padding: 2px 5px">: {{ $registrasi->nama_dokter }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 5px">Cara Masuk</td>
						<td style="border: none; padding: 2px 5px">: {{ $registrasi->cara_masuk }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 5px">Cara Bayar</td>
						<td style="border: none; padding: 5px">: {{ $registrasi->carabayar_nama }}</td>
					</tr>
					@if ($registrasi->nama_asuransi != '-' && $registrasi->nama_asuransi != '' && $registrasi->nama_asuransi != 'Silahkan Pilih')
					<tr>
						<td style="border: none; padding: 5px">&nbsp;</td>
						<td style="border: none; padding: 5px">: {{ $registrasi->nama_asuransi }}</td>
					</tr>
					@endif
					<tr>
						<td style="border: none; padding: 2px 5px">Status Pembayaran</td>
						<td style="border: none; padding: 2px 5px">: {{ $registrasi->status_kasir }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 5px">Tgl Pembayaran</td>
						<td style="border: none; padding: 2px 5px">: 
							@if ($registrasi->tanggal_bayar != '1990-01-01')
								<?php
									$tglbayar = $registrasi->tanggal_bayar;
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
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br />

	<table style="width: 100%; margin-top: -10px; text-align: left" cellpadding="0" cellspacing="0">
		<thead>
			<tr style="background: #dbdbdb">
				<th colspan="2" align="left" style="padding: 7px; width: 38%">Ringkasan Biaya</th>
				<th align="center" style="padding: 7px; width: 13%">Harga</th>
				<th align="center" style="padding: 7px;  width: 10%">Qty</th>
				<th align="center" style="padding: 7px; width: 13%">Disc(Rp)</th>
				<th align="center" style="padding: 7px; width: 13%">Disc(%)</th>
				<th align="right" style="padding: 7px; width: 13%">Total (Rp.)</th>
			</tr>
		</thead>
		<tbody>
			<?php $nomor = 1; $grandtotal = 0; ?>
			@if(count($administrasi) > 0)
				<tr>
					<td colspan="7" style="padding: 10px 8px"><b>Biaya Administrasi Rumah Sakit</b></td>
				</tr>
				
				@foreach ($administrasi as $item)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 5px 7px;">
							@if ($item->nama_layanan == 'Administrasi Rawat Jalan (pl)' || $item->nama_layanan == 'Administrasi Rawat Jalan (pb)')
								Biaya Administrasi
							@else
								{{ $item->nama_layanan }}
							@endif
						</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 5px 7px">1</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($item->diskon_rp) }}</td>
						<td align="center" style="padding: 5px 7px">{{ $item->diskon_persen }}</td>
						<td align="right" style="padding: 5px 7px;">{{ number_format($item->total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $grandtotal += $item->total; ?>
				@endforeach
			@endif

			@if(count($rawatjalan) > 0)
				<tr>
					<td colspan="7" style="padding: 10px 8px"><b>Biaya Rawat Jalan</b></td>
				</tr>
				
				@foreach ($rawatjalan as $item)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 5px 7px;">
							@if ($item->nama_layanan == 'Administrasi Rawat Jalan (pl)' || $item->nama_layanan == 'Administrasi Rawat Jalan (pb)')
								Biaya Administrasi
							@else
								{{ $item->nama_layanan }}
							@endif
						</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 5px 7px">1</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($item->diskon_rp) }}</td>
						<td align="center" style="padding: 5px 7px">{{ $item->diskon_persen }}</td>
						<td align="right" style="padding: 5px 7px;">{{ number_format($item->total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $grandtotal += $item->total; ?>
				@endforeach
			@endif

			@if(count($rawatinap) > 0)
				<tr>
					<td colspan="7" style="padding: 10px 8px"><b>Biaya Rawat Inap</b></td>
				</tr>
				
				@foreach ($rawatinap as $item)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 5px 7px;">{{ $item->nama_layanan }}</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 5px 7px">1</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($item->diskon_rp) }}</td>
						<td align="center" style="padding: 5px 7px">{{ $item->diskon_persen }}</td>
						<td align="right" style="padding: 5px 7px;">{{ number_format($item->total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $grandtotal += $item->total; ?>
				@endforeach
			@endif

			@if(count($bedah) > 0)
				<tr>
					<td colspan="7" style="padding: 10px 8px"><b>Biaya Rawat Inap</b></td>
				</tr>
				
				@foreach ($bedah as $item)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 5px 7px;">{{ $item->nama_layanan }}</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 5px 7px">1</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($item->diskon_rp) }}</td>
						<td align="center" style="padding: 5px 7px">{{ $item->diskon_persen }}</td>
						<td align="right" style="padding: 5px 7px;">{{ number_format($item->total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $grandtotal += $item->total; ?>
				@endforeach
			@endif

			@if(count($resep) > 0)
				<tr>
					<td align="left" colspan="4" style="padding: 10px 8px"><b>Biaya Obat-obatan (Non Racikan)</b></td>
					<td align="center" style="padding: 10px 8px">{{ number_format($obatan->diskon_rp) }}</td>
					<td align="center" style="padding: 10px 8px">{{ $obatan->diskon_persen }}</td>
					<td align="right" style="padding: 10px 8px"><b style="color: #640404">{{ number_format($obatan->total) }}</b></td>
				</tr>
				<?php $grandtotal += $obatan->total; ?>
				<?php $nomor = 1; ?>
				@foreach ($resep as $item)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 5px 7px;">{{ $item->nama_obat }}</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($item->hja_resep) }}</td>
						<td align="center" style="padding: 5px 7px">{{ $item->jumlah_kecil }}</td>
						<td align="right" style="padding: 5px 7px;" colspan="3"></td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3">{{ number_format($item->total) }}</td> --}}
					</tr>
				<?php $nomor++; ?>

				
				@endforeach
			@endif
			
			@if(count($resepracikan) > 0)
				<tr>
					<td align="left" colspan="4" style="padding: 10px 8px"><b>Biaya Obat-obatan (Racikan)</b></td>
					<td align="center" style="padding: 10px 8px">{{ number_format($obatracikan->diskon_rp) }}</td>
					<td align="center" style="padding: 10px 8px">{{ $obatracikan->diskon_persen }}</td>
					<td align="right" style="padding: 10px 8px"><b style="color: #640404">{{ number_format($obatracikan->total) }}</b></td>
				</tr>
				<?php $grandtotal += $obatracikan->total; ?>
				<?php $nomor = 1; ?>
				@foreach ($resepracikan as $item)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 5px 7px;" colspan="2">{{ $item->label }}</td>
						<td align="center" style="padding: 5px 7px">{{ $item->jumlah }} {{ $item->kemasan }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"><b>{{ number_format($item->total) }}</b></td> --}}
						<td align="right" style="padding: 5px 7px;" colspan="3"></td>
					</tr>
					<?php $informasi = json_decode($item->informasi) ?>
					@foreach ($informasi as $itemin)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%">@</td>
						<td align="left" style="padding: 5px 7px;">{{ $itemin->nama }}</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($itemin->hja_resep) }}</td>
						<td align="center" style="padding: 5px 7px">{{ $itemin->jumlah_kecil }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3">{{ number_format($itemin->total) }}</td> --}}
						<td align="right" style="padding: 5px 7px;" colspan="3"></td>
					</tr>
					@endforeach
				<?php $nomor++; ?>

				
				@endforeach
			@endif

			<tr>
				<td colspan="7"><hr /></td>
			</tr>

			@if ($registrasi->panjar == '0' && $registrasi->cover_asuransi == '0')
				<tr >
					<td colspan="5" align="left" style="padding: 4px 7px; width: 65%;"><b>Grand Total</b></td>
					<td colspan="2" align="right" style="padding: 4px 7px;"><b>Rp. {{ number_format($grandtotal) }}</b></td>
				</tr>
			@endif

			@if ($registrasi->panjar != '0' || $registrasi->cover_asuransi != '0')
				@if ($registrasi->panjar != '0')
					<?php $grandtotal = $grandtotal - $registrasi->panjar; ?>
					<tr>
						<td colspan="5" align="left" style="padding: 7px; width: 65%">Biaya Panjar</td>
						<td colspan="2" align="right" style="padding: 7px"><b>Rp. {{ number_format($registrasi->panjar) }}</b></td>
					</tr>
				@endif

				@if ($registrasi->cover_asuransi != '0')
					<?php $grandtotal = $grandtotal - $registrasi->cover_asuransi; ?>
					<tr>
						<td colspan="5" align="left" style="padding: 7px; width: 65%">Nominal Asuransi</td>
						<td colspan="2" align="right" style="padding: 7px"><b>Rp. {{ number_format($registrasi->cover_asuransi) }}</b></td>
					</tr>
				@endif
				<tr>
					<td colspan="5" align="left" style="padding: 7px; width: 65%">Grand Total</td>
					<td colspan="2" align="right" style="padding: 7px"><b>Rp. {{ number_format($grandtotal) }}</b></td>
				</tr>
			@endif
		</tbody>
	</table>

	<br />

	<br />

	<table style="width: 100%; margin-top: -10px; text-align: left" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 31%">&nbsp;</td>
			<td style="width: 31%">&nbsp;</td>
			<td style="width: 37%" align="center">
				Medan, {{ date('d') }} {{ bulans(date('m')) }} {{ date('Y') }} {{ date('H')}}:{{ date('i') }}<br />
				<div style="padding-top: 7px">Kasir</div>
				<br /><br /><br /><br />
				<span style="text-decoration: underline"><b>{{ \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER').'Nama')) }}</b></span>
			</td>
		</tr>
	</table>
	<br />
	<p>*) Harga obat dan alat kesehatan diatas sudah termasuk PPN</p>
</div>
<div style="position: absolute; left: 16px; bottom: 15px">
	@if ($registrasi->tanggal_bayar != '1990-01-01')
		<?php
			$tglbayar = $registrasi->tanggal_bayar;
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
	:
	{{ date('i') }}:{{ date('s') }}
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
function lahirs($tanggal) {
	$tgl = explode('-', $tanggal);
	$tgllahir = $tgl[2];
	$blnlahir = bulans($tgl[1]);
	$thnlahir = $tgl[0];

	return $tgllahir . ' ' . $blnlahir . ' '. $thnlahir;
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
?>
</body>
</html>
