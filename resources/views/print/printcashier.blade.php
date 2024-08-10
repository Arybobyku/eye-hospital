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
<!--	
<div style="position:fixed; right: 13px; bottom: 10px;">
	<?php
		// KTP = Kwitansi Tagihan Pasien
		$msg = 'RSKM-PV/KTP-'.date('y').'/'.date('m').'/S-';
		$nomor = $surat->surat_ke;
		if ($nomor > 0 && $nomor < 10) { $msg .= '000'.$nomor; }
		else if ($nomor > 9 && $nomor < 100) { $msg .= '00'.$nomor; }
		else if ($nomor > 99 && $nomor < 1000) { $msg .= '0'.$nomor; }
		else if ($nomor > 999 && $nomor < 10000) { $msg .= ''.$nomor; }
		echo $msg;
	?>	
</div>
-->
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

	<div style="width: 100%; text-align: center; margin-top: -14px; margin-bottom: 3px; font-weight: bold">
		KWITANSI TAGIHAN
	</div>

	<div style="width: 100%; height: 1px; background: #353535;"></div>
	<br />

	<table  style="width: 100%;  margin-top: -10px; border: none;" cellpadding="0" cellspacing="0">
		<tr>
			<td style="border: none; padding: 2px 5px; width: 23%">No Kwitansi</td>
			<td style="border: none; padding: 2px 5px">: <?php echo $registrasi->no_kwitansi; ?></td>
		</tr>
		<tr>
			<td style="border: none; padding: 2px 5px">Sudah Terima Dari</td>
			<td style="border: none; padding: 2px 5px">: 
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
				?>
			</td>
		</tr>
		<tr>
			<td style="border: none; padding: 2px 5px">Banyak Uang</td>
			<td style="border: none; padding: 2px 5px">: 
				<?php $grandtotaltop = 0; ?>
				@foreach ($layananpasien as $item)
					<?php $grandtotaltop += $item->total; ?>
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
				@if ($diskon != 0)
					<?php 
						//$grandtotaltop = $grandtotaltop - $diskon; 
					?>
				@endif
				Rp. {{ number_format($grandtotaltop) }}
			</td>
		</tr>
		<tr>
			<td style="border: none; padding: 2px 5px">Terbilang</td>
			<td style="border: none; padding: 2px 5px">: 
				<i>"{{ terbilang($grandtotaltop) }} Rupiah"</i>
			</td>
		</tr>
		<tr>
			<td style="border: none; padding: 2px 5px">Untuk Pembayaran</td>
			<td style="border: none; padding: 2px 5px">: Biaya Pelayanan Rumah Sakit</td>
		</tr>
		<tr>
			<td style="border: none; padding: 2px 5px">Nama Pasien</td>
			<td style="border: none; padding: 2px 5px; text-transform: uppercase;">: {{ $pasien->sebutan }} {{ $registrasi->nama_pasien }}</td>
		</tr>
		<tr>
			<td style="border: none; padding: 2px 5px">No. Rekam Medik</td>
			<td style="border: none; padding: 2px 5px">: {{ $registrasi->rekam_medis }}</td>
		</tr>
		<tr>
			<td style="border: none; padding: 2px 5px">No/Tgl Pendaftaran</td>
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
				RJ{{ $registrasi->no_invoice }}/{{ $tgl }} {{ $bln }} {{ $thn }}
			</td>
		</tr>
	</table>
			
	<br />

	<table style="width: 100%; margin-top: -10px; text-align: left" cellpadding="0" cellspacing="0">
		<thead>
			<tr style="background: #dbdbdb">
				<th colspan="2" align="left" style="padding: 7px; width: 65%">Ringkasan Biaya</th>
				<th align="right" style="padding: 7px">Total (Rp.)</th>
			</tr>
		</thead>
		<tbody>
			<?php $nomor = 1; $grandtotal = 0; $grandtotaltemp = 0; ?>
			<tr>
				<td colspan="3" style="padding: 10px 8px"><b>Biaya Rumah Sakit</b></td>
			</tr>
			
			<?php $nomor = 1; $subtotal = 0; ?>
			
			@if(count($administrasi) > 0)
				@foreach ($administrasi as $item)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%" valign="center"></td>
						<td align="left" style="padding: 5px 7px;">Biaya Administrasi</td>
						<td align="right" style="padding: 5px 7px;">{{ number_format($item->tarif) }}</td>
					</tr>
					<?php $nomor++; ?>

					<?php $subtotal += $item->tarif; ?>

				@endforeach
				
			@endif

			@if(count($rawatjalan) > 0)
			
				@if(count($room) > 0 && $collection->count() < 1)
					@foreach ($room as $item)
						<?php $subtotal += $item->tarif; ?>
					@endforeach
				@else
					<?php $subtotal += 0; ?>
				@endif

				@foreach ($rawatjalan as $item)
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%"></td>
						<td align="left" style="padding: 5px 7px;">Tindakan Rawat Jalan</td>
						<td align="right" style="padding: 5px 7px;">{{ number_format($item->total_tarif) }}</td>
					</tr>
					<?php $nomor++; ?>

					<?php $subtotal += $item->total_tarif; ?>
				@endforeach
			@endif

			@if ($total_obat != 0)
				<tr>
					<td align="center" style="padding: 5px 7px; width: 5%"></td>
					<td align="left" style="padding: 5px 7px;">Obat-Obatan</td>
					<td align="right" style="padding: 5px 7px;">{{ number_format($total_obat) }}</td>
				</tr>
				<?php $subtotal += $total_obat; ?>
			@endif

			@foreach($collection as $row)
				<tr>
					<td align="center" style="padding: 5px 7px; width: 5%"></td>
					<td align="left" style="padding: 5px 7px;">{{ $row->jenis }}</td>
					<td align="right" style="padding: 5px 7px;">{{ number_format($row->tarif) }}</td>
				</tr>
				<?php $subtotal += $row->tarif; ?>
			@endforeach

			<?php $grandtotal += $subtotal; ?>
			<?php $grandtotaltemp += $subtotal; ?>

			<tr style="border-bottom: 1px solid #343224">
				<td style="padding: 5px 7px; font-weight: bold;" colspan="2">Sub Total</td>
				<td align="right" style="padding: 5px 7px; font-weight: bold;">{{ number_format($subtotal) }}</td>
			</tr>

			{{-- <tr>
				<td colspan="3"><hr /></td>
			</tr> --}}

			@if(count($honor) > 0 || count($honorbedah) > 0)
				<tr>
					<td colspan="3" style="padding: 10px 8px"><b>Biaya Dokter</b></td>
				</tr>
			@endif

			@if(count($honor) > 0)

				<?php $nomor = 1; $subtotal = 0; ?>
				
				@foreach ($honor as $item)
					
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%" valign="center"></td>
						<td align="left" style="padding: 5px 7px;">
							{{ $item->nama_layanan }}<br />
							{{ $item->nama_dokter }}
						</td>
						<td align="right" style="padding: 5px 7px;">{{ number_format($item->tarif) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $subtotal += $item->tarif; ?>
				
				@endforeach
					
				<?php $grandtotal += $subtotal; ?>
				<?php $grandtotaltemp += $subtotal; ?>
				
				@if(count($honorbedah) < 1)
					<tr style="border-bottom: 1px solid #343224">
						<td style="padding: 5px 7px; font-weight: bold;" colspan="2">Sub Total</td>
						<td align="right" style="padding: 5px 7px; font-weight: bold;">{{ number_format($subtotal) }}</td>
					</tr>
				@endif

			@endif

			@if(count($honorbedah) > 0)

				<?php $nomor = 1; $subtotalBedah = 0; ?>
				
				@foreach ($honorbedah as $item)
					
					<tr>
						<td align="center" style="padding: 5px 7px; width: 5%" valign="center"></td>
						<td align="left" style="padding: 5px 7px;">
							Honor Operator Bedah<br />
							{{ $item->nama_dokter }}
						</td>
						<td align="right" style="padding: 5px 7px;">{{ number_format($item->total_tarif) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $subtotalBedah += $item->total_tarif; ?>
				
				@endforeach
					
				<?php $grandtotal += $subtotalBedah ; ?>
				<?php $grandtotaltemp += $subtotalBedah; ?>

				<tr style="border-bottom: 1px solid #343224">
					<td style="padding: 5px 7px; font-weight: bold;" colspan="2">Sub Total</td>
					<td align="right" style="padding: 5px 7px; font-weight: bold;">{{ number_format($subtotalBedah + $subtotal) }}</td>
				</tr>

			@endif

			@if ($registrasi->panjar == '0' && $registrasi->cover_asuransi == '0')
				<?php 
					// $grandtotaltemp = $grandtotaltemp + $diskon 
				?>
				<tr>
					<td colspan="2" align="left" style="padding: 4px 7px; width: 65%;">
						<b>Grand Total</b>
					</td>
					<td align="right" style="padding: 4px 7px;"><b>Rp. {{ number_format($grandtotaltemp) }}</b></td>
				</tr>
			@endif

			@if ($registrasi->panjar != '0' || $registrasi->cover_asuransi != '0')
				@if ($registrasi->panjar != '0')
					<?php $grandtotal = $grandtotal - $registrasi->panjar; ?>
					<tr>
						<td colspan="2" align="left" style="padding: 7px; width: 65%"><b>Biaya Panjar</b></td>
						<td align="right" style="padding: 7px"><b>Rp. {{ number_format($registrasi->panjar) }}</b></td>
					</tr>
				@endif

				@if ($registrasi->cover_asuransi != '0')
					<?php $grandtotal = $grandtotal - $registrasi->cover_asuransi; ?>
					<tr>
						<td colspan="2" align="left" style="padding: 7px; width: 65%"><b>Nominal Asuransi</b></td>
						<td align="right" style="padding: 7px"><b>Rp. {{ number_format($registrasi->cover_asuransi) }}</b></td>
					</tr>
				@endif
				<?php 
					// $grandtotaltemp = $grandtotaltemp + $diskon 
				?>
				<tr>
					<td colspan="2" align="left" style="padding: 7px; width: 65%"><b>Grand Total</b></td>
					<td align="right" style="padding: 7px"><b>Rp. {{ number_format($grandtotaltemp) }}</b></td>
				</tr>
			@endif
			@if ($diskon != 0)
				<?php 
				$grandtotal = $grandtotal - $diskon; 
				?>
				<tr >
					<td colspan="2" align="left" style="padding: 4px 7px; width: 65%;"><b>Total Diskon</b></td>
					<td align="right" style="padding: 4px 7px;"><b>Rp. {{ number_format($diskon) }}</b></td>
				</tr>
				<tr >
					<td colspan="2" align="left" style="padding: 4px 7px; width: 65%;"><b>Total Pembayaran</b></td>
					<td align="right" style="padding: 4px 7px;"><b>Rp. {{ number_format($grandtotal) }}</b></td>
				</tr>
			@endif

			@if (
						$registrasi->carabayar_uuid != '1bddd542-fd1e-4b6a-b629-53bd35428796' &&
						$registrasi->carabayar_uuid != 'e3ed042d-2b41-4672-bcc2-7a816a622667' &&
						$registrasi->carabayar_uuid != 'd494b806-9af6-4ccc-af2a-50be75e0814f' &&
						$registrasi->carabayar_uuid != '91cf4fa7-f35f-41e2-8e29-0ed6a3982da3' &&
						$registrasi->carabayar_uuid != 'bca360e3-aadc-4b7c-8308-0f0ba85876e1' &&
						$registrasi->carabayar_uuid != 'f93e2aeb-0f76-4f16-8bc0-b291eb16e740' &&
						$registrasi->carabayar_uuid != '50f0abb5-2a71-4e86-bd36-a238ef3fa118'
					) 
					@if (($registrasi->apakah_paket == 'Ya' || $registrasi->apakah_paket == 'ya') && $registrasi->cover_asuransi != 0)
						<tr>
							<td colspan="2" align="left" style="padding: 4px 7px; width: 65%"><b>Dibayarkan pasien</b></td>
							<td align="right" style="padding: 4px 7px"><b>Rp. {{ number_format($grandtotal) }}</b></td>
						</tr>
					@elseif (($registrasi->apakah_paket == 'Tidak' || $registrasi->apakah_paket == 'tidak') && $registrasi->cover_asuransi != 0)
						<tr>
							<td colspan="2" align="left" style="padding: 4px 7px; width: 65%"><b>Dibayarkan pasien</b></td>
							<td align="right" style="padding: 4px 7px"><b>Rp. {{ number_format($grandtotal) }}</b></td>
						</tr>
					@endif
				
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
				Medan, 
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

				@endif
				<br />
				<div style="padding-top: 7px">Kasir</div>
				<br /><br /><br /><br /><br />
				<span style="text-decoration: underline">
					<b>{{ \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER').'Nama')) }}</b>
				</span>
			</td>
		</tr>
	</table>
</div>
<!--
<div style="position: absolute; left: 16px; bottom: 15px">Dicetak pada 
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
-->
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
