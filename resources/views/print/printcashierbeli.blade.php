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
		// KOS = Kwitansi Obat Bebas
		$msg = 'RSKM-PV/KOS-'.date('y').'/'.date('m').'/S-';
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
	<div style="width: 100%; height: 1px; background: #353535; margin-top: -28px"></div>
	<br />

	<div style="width: 100%; text-align: center; margin-top: -14px; margin-bottom: 3px; font-weight: bold">
		RINCIAN TAGIHAN PEMBELIAN OBAT/ALKES
	</div>

	<div style="width: 100%; height: 1px; background: #353535;"></div>
	<br />

	<table style="width: 100%; margin-top: -10px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 50%">
				<table  style="width: 100%; border: none;" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border: none; padding: 2px 5px">No Invoice</td>
						<td style="border: none; padding: 2px 5px">: PB{{ $pasien->no_invoice }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 5px">Tgl Pendaftaran</td>
						<td style="border: none; padding: 2px 5px">: 
							<?php
								$tglbayar = $pasien->tanggal;
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
				</table>
			</td>
			<td style="width: 50%">
				<table style="width: 100%; border: none;" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border: none; padding: 2px 5px">Status Pembayaran</td>
						<td style="border: none; padding: 2px 5px">: {{ $pasien->pembayaran }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 5px">Tgl Pembayaran</td>
						<td style="border: none; padding: 2px 5px">: 
							@if ($pasien->tanggal_bayar != '1990-09-09')
								<?php
									$tglbayar = $pasien->tanggal_bayar;
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
	<table style="width: 100%; margin-top: 0px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="border: none; padding: 2px 5px; width: 22%">Banyak Uang</td>
			<td style="border: none; padding: 2px 5px" align="left">: 
				<?php $grandtotaltop = 0; ?>
				@foreach ($resep_obat as $item)
					<?php $grandtotaltop += $item->total; ?>
				@endforeach
				@foreach ($resep_alkes as $item)
					<?php $grandtotaltop += $item->total; ?>
				@endforeach
				@foreach ($rawatjalan as $item)
					<?php $grandtotaltop += $item->total_total; ?>
				@endforeach
				@foreach ($resepracikan as $item)
					<?php $informasi = json_decode($item->informasi) ?>
					@foreach ($informasi as $itemin)
						<?php $grandtotaltop += $itemin->total; ?>
					@endforeach
				@endforeach
				Rp. {{ number_format($grandtotaltop) }}
			</td>
		</tr>
		<tr>
			<td style="border: none; padding: 2px 5px">Terbilang</td>
			<td style="border: none; padding: 2px 5px">: 
				<i>"{{ terbilang($grandtotaltop) }} Rupiah"</i>
			</td>
		</tr>
	</table>
	<br />

	<table style="width: 100%; margin-top: -10px; text-align: left" cellpadding="0" cellspacing="0">
		<thead>
			<tr style="background: #dbdbdb">
				<th colspan="2" align="left" style="padding: 7px; width: 64%">Ringkasan Biaya</th>
				<th align="center" style="padding: 7px; width: 13%">Harga</th>
				<th align="center" style="padding: 7px;  width: 10%">Qty</th>
				<th align="right" style="padding: 7px; width: 13%">Total (Rp.)</th>
			</tr>
		</thead>
		<tbody>
			<?php $nomor = 1; $grandtotal = 0; ?>

			@if(count($rawatjalan) > 0)

				<?php $nomor = 1; $subtotal = 0; $dokter = '' ?>
				<tr>
					<td colspan="5" style="padding: 10px 8px"><b>Tindakan Rawat Jalan</b></td>
				</tr>
				@foreach ($rawatjalan as $item)
					<tr>
						<td align="center" style="padding: 2px 3px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 2px 3px;">{{ $item->nama_layanan }}</td>
						<td align="center" style="padding: 2px 3px">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 2px 3px">{{ $item->jumlah_nama_layanan }}</td>
						<td align="right" style="padding: 2px 3px;">{{ number_format($item->total_total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $subtotal += $item->total_total; ?>
				@endforeach

				<tr style="border-bottom: 1px solid #343224">
					<td style="padding: 2px 3px; font-weight: bold;" colspan="4">Sub Total</td>
					<td align="right" style="padding: 5px 7px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>

				<?php $grandtotal += $subtotal; ?>
			@endif

			@if (count($resep_obat) > 0 || count($resep_alkes) > 0) 
				<tr>
					<td colspan="5" style="padding: 10px 8px"><b>Farmasi Pelayanan</b></td>
				</tr>
			@endif

			@if(count($resep_obat) > 0)

			<?php $nomor = 1; $subtotal = 0; ?>

				<tr>
					<td colspan="5" style="padding: 0px 8px 5px">- <i>Obat-obatan</i></td>
				</tr>
				<?php $nomor = 1; ?>
				@foreach ($resep_obat as $item)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 5px 7px;">{{ $item->nama_obat }}</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($item->hja_non_resep) }}</td>
						<td align="center" style="padding: 5px 7px">{{ $item->jumlah_kecil }}</td>
						<td align="right" style="padding: 5px 7px;">{{ number_format($item->total) }}</td>
					</tr>
					<?php $nomor++; ?>

					<?php $subtotal += $item->total; ?>
				@endforeach
				
				<tr>
					<td style="padding: 5px 7px 10px; font-weight: bold;" colspan="4">Sub Total</td>
					<td align="right" style="padding: 5px 7px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				<?php $grandtotal += $subtotal; ?>
			@endif

			@if(count($resep_alkes) > 0)

			<?php $nomor = 1; $subtotal = 0; ?>

				<tr>
					<td colspan="5" style="padding: 0px 8px 5px">- <i>Alkes</i></td>
				</tr>
				<?php $nomor = 1; ?>
				@foreach ($resep_alkes as $item)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 5px 7px;">{{ $item->nama_obat }}</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($item->hja_non_resep) }}</td>
						<td align="center" style="padding: 5px 7px">{{ $item->jumlah_kecil }}</td>
						<td align="right" style="padding: 5px 7px;">{{ number_format($item->total) }}</td>
					</tr>
					<?php $nomor++; ?>

					<?php $subtotal += $item->total; ?>
				@endforeach

				<tr>
					<td style="padding: 5px 7px 10px; font-weight: bold;" colspan="4">Sub Total</td>
					<td align="right" style="padding: 5px 7px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				<?php $grandtotal += $subtotal; ?>
			@endif

			@if(count($resepracikan) > 0)
				<?php $nomor = 1; $subtotal = 0; ?>
				<tr>
					<td colspan="5" style="padding: 0px 8px 5px">- <i>Obat-Obatan (Racikan)</i></td>
				</tr>
				
				@foreach ($resepracikan as $item)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 5px 7px;">{{ $item->label }}</td>
						<td align="center" style="padding: 5px 7px" colspan="3">{{ $item->jumlah }} {{ $item->kemasan }}</td>
					<?php $informasi = json_decode($item->informasi) ?>
					@foreach ($informasi as $itemin)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%">@</td>
						<td align="left" style="padding: 5px 7px;">{{ $itemin->nama }}</td>
						<td align="center" style="padding: 5px 7px">{{ number_format($itemin->hja_resep) }}</td>
						<td align="center" style="padding: 5px 7px">{{ $itemin->jumlah_kecil }}</td>
						<td align="right" style="padding: 5px 7px;">{{ number_format($itemin->total) }}</td>

						<?php $subtotal += $itemin->total; ?>
					</tr>
					@endforeach
				<?php $nomor++; ?>

				@endforeach

				<tr>
					<td style="padding: 2px 3px; font-weight: bold;" colspan="3">Sub Total</td>
					<td align="right" style="padding: 2px 3px; font-weight: bold;" colspan="2">{{ number_format($subtotal) }}</td>
				</tr>
				<?php $grandtotal += $subtotal; ?>
			@endif

			<!-- Disini Resep Racikan -->

			<tr>
				<td colspan="5"><hr /></td>
			</tr>
			<tr >
				<td colspan="3" align="left" style="padding: 4px 7px; width: 65%;"><b>Grand Total</b></td>
				<td colspan="2" align="right" style="padding: 4px 7px;"><b>Rp. {{ number_format($grandtotal) }}</b></td>
			</tr>
			<tr >
				<td colspan="3" align="left" style="padding: 4px 7px; width: 65%;"><b>Total Pembayaran</b></td>
				<td colspan="2" align="right" style="padding: 4px 7px;"><b>Rp. {{ number_format($grandtotal) }}</b></td>
			</tr>
		</tbody>
	</table>

	<br />

	<br />

	<table style="width: 100%; margin-top: -10px; text-align: left" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 31%">&nbsp;</td>
			<td style="width: 31%">&nbsp;</td>
			<td style="width: 37%" align="center">
				Medan, 
				@if ($pasien->tanggal_bayar != '1990-09-09')
					<?php
						$tglbayar = $pasien->tanggal_bayar;
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
				{{ date('H')}}:{{ date('i') }}<br />
				<div style="padding-top: 7px">Kasir</div>
				<br /><br /><br /><br /><br />
				<span style="text-decoration: underline"><b>{{ \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER').'Nama')) }}</b></span>
			</td>
		</tr>
	</table>
	<br />
	<p>*) Harga obat dan alat kesehatan diatas sudah termasuk PPN 10%</p>
</div>
<div style="position: absolute; left: 16px; bottom: 15px">
	Dicetak pada 
	@if ($pasien->tanggal_bayar != '1990-09-09')
	<?php
		$tglbayar = $pasien->tanggal_bayar;
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
