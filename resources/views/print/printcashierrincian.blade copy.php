<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Invoice</title>
    <style>
    @page { margin: 5px;  }
    body { margin: 5px; }
        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }
				table {page-break-before:auto;}
		
    </style>
</head>
<body>

<?php $fullpath = storage_path('app/public/header.png');  ?>

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
						<span style="font-size: 13px; position: relative; left: -16px; top: -3px">RUMAH SAKIT KHUSUS MATA</span><br />
						<span style="font-size: 30px; position: relative; left: -6px; top: -8px; color: #18365d">PRIMA VISION</span><br />
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
	<div style="width: 100%; height: 1px; background: #353535; margin-top: -32px"></div>
	<br />

	<div style="width: 100%; font-size: 10pt; text-align: center; margin-top: -18px; margin-bottom: 3px; font-weight: bold">
		RINCIAN TAGIHAN
	</div>

	<div style="width: 100%;  margin-top: -4px; height: 1px; background: #353535;"></div>
	<br />

	<table style="width: 100%; margin-top: -17px; font-size: 11pt" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 50%">
				<table  style="width: 100%; border: none;" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">No Invoice</td>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">: INV{{ $registrasi->no_invoice }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 1px;font-size: 11pt">Nama Lengkap</td>
						<td style="border: none; padding: 2px 1px;font-size: 11pt">: {{ ucwords(strtolower($pasien->sebutan)) }} {{ ucwords(strtolower($registrasi->nama_pasien)) }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 1px;font-size: 11pt">No. Rekam Medik</td>
						<td style="border: none; padding: 2px 1px;font-size: 11pt">: {{ $registrasi->rekam_medis }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">Nomor Pendaftaran</td>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">: RJ{{ $registrasi->nomor }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">Tgl Pendaftaran</td>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">: 
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
						<td style="border: none; padding: 2px 1px; font-size: 11pt">Umur/Tgl.Lahir</td>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">: {{ umurs($pasien->tanggal_lahir) }}/{{ lahirs($pasien->tanggal_lahir) }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">Alamat</td>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">: {{ ucwords(strtolower($pasien->alamat)) }}</td>
					</tr>
					@if ($registrasi->nama_asuransi != '-')
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					@endif
				</table>
			</td>
			<td style="width: 50%" valign="top">
				<table style="width: 100%; border: none;" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">Dokter yang menangani</td>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">: {{ $registrasi->nama_dokter }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">Cara Bayar</td>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">: {{ $registrasi->carabayar_nama }}</td>
					</tr>
					@if ($registrasi->nama_asuransi != '-' && $registrasi->nama_asuransi != '' && $registrasi->nama_asuransi != 'Silahkan Pilih')
					<tr>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">&nbsp;</td>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">: {{ $registrasi->nama_asuransi }}</td>
					</tr>
					@endif
					<tr>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">Status Pembayaran</td>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">: {{ $registrasi->status_kasir }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">Tgl Pembayaran</td>
						<td style="border: none; padding: 2px 1px; font-size: 11pt">: 
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

	<table style="page-break-after: avoid; width: 100%; margin-top: -28px; text-align: left; font-size: 10.7pt;" cellpadding="0" cellspacing="0">
		<thead>
			<tr style="background: #dbdbdb">
				<th colspan="2" align="left" style="padding: 2px 1px; width: 39%">Ringkasan Biaya</th>
				<th align="center" style="padding: 2px 1px; width: 22%">Tgl Transaksi</th>
				<th align="center" style="padding: 2px 1px; width: 9%">Harga</th>
				<th align="center" style="padding: 2px 1px;  width: 4%">Qty</th>
				<th align="center" style="padding: 2px 1px; width: 10%">Disc(Rp)</th>
				<th align="center" style="padding: 2px 1px; width: 6%">Disc(%)</th>
				<th align="right" style="padding: 2px 1px; width: 10%">Total (Rp.)</th>
			</tr>
		</thead>
		<tbody>
			

			<?php $grandtotal = 0; ?>
			
			@if(count($administrasi) > 0)
				<tr>
					<td colspan="7" style="padding: 10px 8px"><b>Biaya Administrasi</b></td>
				</tr>

				<?php $nomor = 1; $subtotal = 0; ?>
				
				@foreach ($administrasi as $item)
					
					<tr>
						<td align="center" style="padding: 0px 3px; width: 5%" valign="center">{{ $nomor }}.</td>
						<td align="left" style="padding: 8px 2px;">
							@if ($item->nama_layanan == 'Administrasi Rawat Jalan (pl)')
								Biaya Pendaftaran + Adm Rawat Jalan (pl)
							@elseif($item->nama_layanan == 'Administrasi Rawat Jalan (pb)')
								Biaya Pendaftaran + Adm Rawat Jalan (pl)
							@endif
						</td>
						<td align="center" style="padding: 8px 2px; width: 17%" valign="top">{{ ubahs($item->created_at) }}</td>
						<td align="center" style="padding: 8px 2px" valign="top">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 8px 2px" valign="top">1</td>
						<td align="center" style="padding: 8px 2px" valign="top">{{ number_format($item->diskon_rp) }}</td>
						<td align="center" style="padding: 8px 2px" valign="top">{{ $item->diskon_persen }}</td>
						<td align="right" style="padding: 8px 2px;" valign="top">{{ number_format($item->total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $subtotal += $item->total; ?>
				@endforeach

				<tr style="border-bottom: 1px solid #343224">
					<td style="padding: 10px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 10px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				<?php $grandtotal += $subtotal; ?>
			@endif

			@if(count($honor) > 0)
				<tr>
					<td colspan="8" style="padding: 10px 8px"><b>Honor Konsultasi Rawat Jalan</b></td>
				</tr>

				<?php $nomor = 1; $subtotal = 0; ?>
				
				@foreach ($honor as $item)
					
					<tr>
						<td align="center" style="padding: 8px 2px; width: 5%" valign="center">{{ $nomor }}.</td>
						<td align="left" style="padding: 8px 2px;">
							{{ $item->nama_layanan }}<br />
							{{ $item->nama_dokter }}
						</td>
						<td align="center" style="padding: 8px 2px; width: 17%" valign="top">{{ ubahs($item->created_at) }}</td>
						<td align="center" style="padding: 8px 2px" valign="top">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 8px 2px" valign="top">1</td>
						<td align="center" style="padding: 8px 2px" valign="top">{{ number_format($item->diskon_rp) }}</td>
						<td align="center" style="padding: 8px 2px" valign="top">{{ $item->diskon_persen }}</td>
						<td align="right" style="padding: 8px 2px;" valign="top">{{ number_format($item->total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $subtotal += $item->total; ?>
				@endforeach

				<tr style="border-bottom: 1px solid #343224">
					<td style="padding: 10px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 10px 3px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				<?php $grandtotal += $subtotal; ?>
			@endif

			@if(count($rawatjalan) > 0)

				<?php $nomor = 1; $subtotal = 0; $dokter = '' ?>
				
				@foreach ($rawatjalan as $item)

					@if ($dokter != $item->nama_dokter)
					<tr>
						<td colspan="8" style="padding: 10px 8px"><b>Tindakan Rawat Jalan</b> : <b>{{ $item->nama_dokter }}</b></td>
					</tr>
					<?php $dokter = $item->nama_dokter; ?>
					@endif

					<tr>
						<td align="center" style="padding: 8px 2px; width: 3%">{{ $nomor }}.</td>
						<td align="left" style="padding: 8px 2px;">{{ $item->nama_layanan }}</td>
						<td align="center" style="padding: 8px 2px; width: 17%" valign="top">{{ ubahs($item->created_at) }}</td>
						<td align="center" style="padding: 8px 2px" valign="top">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 8px 2px" valign="top">{{ $item->jumlah_nama_layanan }}</td>
						<td align="center" style="padding: 8px 2px" valign="top">{{ number_format($item->total_diskon_rp) }}</td>
						<td align="center" style="padding: 8px 2px" valign="top">{{ $item->total_diskon_persen }}</td>
						<td align="right" style="padding: 8px 2px;" valign="top">{{ number_format($item->total_total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $subtotal += $item->total_total; ?>
				@endforeach

				<tr style="border-bottom: 1px solid #343224">
					<td style="padding: 10px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 10px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>

				<?php $grandtotal += $subtotal; ?>
			@endif

			@if(count($room) > 0)

				<?php $nomor = 1; $subtotal = 0; ?>

				<tr>
					<td colspan="8" style="padding: 10px 8px"><b>Room</b></td>
				</tr>
				
				@foreach ($room as $item)
					
					<tr>
						<td align="center" style="padding: 8px 3px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 8px 3px;">{{ $item->nama_layanan }}</td>
						<td align="center" style="padding: 8px 3px; width: 17%" valign="top">{{ ubahs($item->created_at) }}</td>
						<td align="center" style="padding: 8px 3px" valign="top">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 8px 3px" valign="top">1</td>
						<td align="center" style="padding: 8px 3px" valign="top">{{ number_format($item->diskon_rp) }}</td>
						<td align="center" style="padding: 8px 3px" valign="top">{{ $item->diskon_persen }}</td>
						<td align="right" style="padding: 8px 3px;" valign="top">{{ number_format($item->total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $subtotal += $item->total; ?>
				@endforeach

				<tr style="border-bottom: 1px solid #343224">
					<td style="padding: 10px 7px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 10px 7px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>

				<?php $grandtotal += $subtotal; ?>
			@endif

			{{-- @if(count($rawatinap) > 0)
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
					<td colspan="7" style="padding: 10px 8px"><b>Biaya Operasi/Bedah</b></td>
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
			@endif --}}

			@if (count($resep_obat) > 0 || count($resep_alkes) > 0) 
				<tr>
					<td colspan="8" style="padding: 10px 8px"><b>Farmasi Pelayanan</b></td>
				</tr>
			@endif

			@if(count($resep_obat) > 0)

			<?php $nomor = 1; $subtotal = 0; ?>

				<tr>
					<td colspan="8" style="padding: 6px 8px 5px">- <i>Obat-obatan</i></td>
				</tr>
				{{-- <tr>
					<td align="left" colspan="4" style="padding: 10px 8px"><b>Farmasi Pelayanan</b></td>
					<td align="center" style="padding: 10px 8px">{{ number_format($obatan->diskon_rp) }}</td>
					<td align="center" style="padding: 10px 8px">{{ $obatan->diskon_persen }}</td>
					<td align="right" style="padding: 10px 8px"><b style="color: #640404">{{ number_format($obatan->total) }}</b></td>
				</tr> --}}
				<?php $nomor = 1; ?>
				@foreach ($resep_obat as $item)
					<tr>
						<td align="center" style="padding: 5px 3px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 5px 3px;">{{ $item->nama_obat }}</td>
						<td align="center" style="padding: 5px 3px; width: 17%" valign="top">{{ ubahs($item->created_at) }}</td>
						<td align="center" style="padding: 5px 3px">{{ number_format($item->hja_resep) }}</td>
						<td align="center" style="padding: 5px 3px">{{ $item->jumlah_kecil }}</td>
						<td align="right" style="padding: 5px 3px;" colspan="3">{{ number_format($item->total) }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"></td> --}}
					</tr>
					<?php $nomor++; ?>

					<?php $subtotal += $item->total; ?>
				@endforeach
				@if (count($resep_alkes) > 0)
				<tr>
					<td style="padding: 10px 3px 10px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 10px 3px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				@else
					<tr>
						<td style="padding: 10px 3px 10px; font-weight: bold;" colspan="5">Sub Total</td>
						<td style="padding: 10px 3px 10px;" align="center">{{ $diskon_rp }}</td>
						<td style="padding: 10px 3px 10px;" align="center">{{ $diskon_persen }}</td>
						<td align="right" style="padding: 1px 3px; font-weight: bold;">
							<?php 
								$sementara = $subtotal; 
								if ($diskon_rp > 0) {
									$sementara = $sementara - $diskon_rp;
								}
								
								if ($diskon_persen > 0) {
									$n_persen = (int) ($subtotal * ($diskon_persen/100));
									$sementara = $sementara - $n_persen;
								}
							?>
							{{ number_format($sementara) }}
						</td>
					</tr>
				@endif
				<?php $grandtotal += $subtotal; ?>
			@endif

			@if(count($resep_alkes) > 0)

			<?php $nomor = 1; $subtotal = 0; ?>

				<tr>
					<td colspan="8" style="padding: 6px 8px 5px">- <i>Alkes</i></td>
				</tr>
				{{-- <tr>
					<td align="left" colspan="4" style="padding: 10px 8px"><b>Farmasi Pelayanan</b></td>
					<td align="center" style="padding: 10px 8px">{{ number_format($obatan->diskon_rp) }}</td>
					<td align="center" style="padding: 10px 8px">{{ $obatan->diskon_persen }}</td>
					<td align="right" style="padding: 10px 8px"><b style="color: #640404">{{ number_format($obatan->total) }}</b></td>
				</tr> --}}
				<?php $nomor = 1; ?>
				@foreach ($resep_alkes as $item)
					<tr>
						<td align="center" style="padding: 5px 3px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 5px 3px;">{{ $item->nama_obat }}</td>
						<td align="center" style="padding: 5px 3px; width: 17%" valign="top">{{ ubahs($item->created_at) }}</td>
						<td align="center" style="padding: 5px 3px">{{ number_format($item->hja_resep) }}</td>
						<td align="center" style="padding: 5px 3px">{{ $item->jumlah_kecil }}</td>
						<td align="right" style="padding: 5px 3px;" colspan="3">{{ number_format($item->total) }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"></td> --}}
					</tr>
					<?php $nomor++; ?>

					<?php $subtotal += $item->total; ?>
				@endforeach

				<tr>
					<td style="padding: 10px 3px 10px; font-weight: bold;" colspan="5">Sub Total</td>
					<td style="padding: 10px 3px 10px;" align="center">{{ $diskon_rp }}</td>
					<td style="padding: 10px 3px 10px;" align="center">{{ $diskon_persen }}</td>
					<td align="right" style="padding: 1px 3px; font-weight: bold;">
						<?php 
							$sementara = $subtotal; 
							if ($diskon_rp > 0) {
								$sementara = $sementara - $diskon_rp;
							}
							
							if ($diskon_persen > 0) {
								$n_persen = (int) ($subtotal * ($diskon_persen/100));
								$sementara = $sementara - $n_persen;
							}
						?>
						{{ number_format($sementara) }}
					</td>
				</tr>
				<?php $grandtotal += $subtotal; ?>
			@endif
			
			@if(count($resepracikan) > 0)
				<?php $nomor = 1; $subtotal = 0; ?>
				<tr>
					<td colspan="8" style="padding: 10px 8px 5px">- <i>Obat-Obatan (Racikan)</i></td>
				</tr>
				<?php $subtotal += $obatracikan->total; ?>
				
				@foreach ($resepracikan as $item)
					<tr>
						<td align="center" style="padding: 10px 3px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 3px;" >{{ $item->label }}</td>
						<td align="center" style="padding: 10px 3px; width: 17%" colspan="2" valign="top">{{ ubahs($item->created_at) }}</td>
						<td align="center" style="padding: 10px 3px">{{ $item->jumlah }} {{ $item->kemasan }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"><b>{{ number_format($item->total) }}</b></td> --}}
						<td align="right" style="padding: 10px 3px;" colspan="3"></td>
					</tr>
					<?php $informasi = json_decode($item->informasi) ?>
					@foreach ($informasi as $itemin)
					<tr>
						<td align="center" style="padding: 10px 3px; width: 5%">@</td>
						<td align="left" style="padding: 10px 3px;" colspan="2">{{ $itemin->nama }}</td>
						<td align="center" style="padding: 10px 3px">{{ number_format($itemin->hja_resep) }}</td>
						<td align="center" style="padding: 10px 3px">{{ $itemin->jumlah_kecil }}</td>
						<td align="right" style="padding: 10px 3px;" colspan="3">{{ number_format($itemin->total) }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"></td> --}}
					</tr>
					@endforeach
				<?php $nomor++; ?>

				@endforeach

				<tr>
					<td style="padding: 1px 3px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 10px 3px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				<?php $grandtotal += $subtotal; ?>
			@endif

			<tr>
				<td colspan="8"><hr /></td>
			</tr>

			<?php $last = $grandtotal; ?>

			@if ($registrasi->panjar == '0' && $registrasi->cover_asuransi == '0')
			<?php $last = $last + $diskon ?>
				<tr >
					<td colspan="6" align="left" style="padding: 10px 3px; width: 65%;"><b>Grand Total</b></td>
					<td colspan="2" align="right" style="padding: 10px 3px;"><b>Rp. {{ number_format($last) }}</b></td>
				</tr>
			@endif

			

			@if ($registrasi->panjar != '0' || $registrasi->cover_asuransi != '0')
				@if ($registrasi->panjar != '0')
					<?php $grandtotal = $grandtotal - $registrasi->panjar; ?>
					<tr>
						<td colspan="6" align="left" style="padding: 10px 3px; width: 65%"><b>Biaya Panjar</b></td>
						<td colspan="2" align="right" style="padding: 10px 3px"><b>Rp. {{ number_format($registrasi->panjar) }}</b></td>
					</tr>
				@endif

				@if ($registrasi->cover_asuransi != '0')
					<?php $grandtotal = $grandtotal - $registrasi->cover_asuransi; ?>
					<tr>
						<td colspan="6" align="left" style="padding: 10px 3px; width: 65%"><b>Nominal Asuransi</b></td>
						<td colspan="2" align="right" style="padding: 10px 3px"><b>Rp. {{ number_format($registrasi->cover_asuransi) }}</b></td>
					</tr>
				@endif
				<?php $last = $last + $diskon ?>
				<tr>
					<td colspan="6" align="left" style="padding: 10px 3px; width: 65%"><b>Grand Total</b></td>
					<td colspan="2" align="right" style="padding: 10px 3px"><b>Rp. {{ number_format($last) }}</b></td>
				</tr>
				
			@endif
			
			@if ($diskon != 0)
				<?php 
					// $grandtotal = $grandtotal - $diskon; 
				?>
				<tr >
					<td colspan="6" align="left" style="padding: 5px 3px; width: 65%;"><b>Total Diskon</b></td>
					<td colspan="2" align="right" style="padding: 5px 3px;"><b>Rp. {{ number_format($diskon) }}</b></td>
				</tr>
			@endif
			<tr>
				<td colspan="6" align="left" style="padding: 5px 3px; width: 65%"><b>Total Pembayaran</b></td>
				<td colspan="2" align="right" style="padding: 5px 3px"><b>Rp. {{ number_format($grandtotal) }}</b></td>
			</tr>
			<tr>
				<td style="width: 31%" colspan="2">&nbsp;</td>
				<td style="width: 31%" colspan="2">&nbsp;</td>
				<td style="width: 37%; font-size: 10pt" colspan="4" align="center">
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
						-
					@endif
					{{ date('H')}}:{{ date('i') }}<br />
					<div style="padding-top: 7px; font-size: 10pt">Kasir</div>
					<br /><br /><br />
					<span style="text-decoration: underline; font-size: 10pt"><b>{{ \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER').'Nama')) }}</b></span>
				</td>
			</tr>
			<tr>
				<td colspan="8" style="font-size: 10pt">*) Harga obat dan alat kesehatan diatas sudah termasuk PPN 10%</td>
			</tr>
		</tbody>
	</table>

{{-- <div style="position: absolute; left: 16px; bottom: 15px">
	@if ($registrasi->tanggal_bayar != '1990-01-01')
		<?php
			// $tglbayar = $registrasi->tanggal_bayar;
			// $data = explode('-',$tglbayar);
			// $thn = $data[0]; $bln = $data[1]; $tgl = $data[2];
			// if ($bln == '01') { $bln = 'Januari'; }
			// else if ($bln == '02') { $bln = 'Februari'; }
			// else if ($bln == '03') { $bln = 'Maret'; }
			// else if ($bln == '04') { $bln = 'April'; }
			// else if ($bln == '05') { $bln = 'Mei'; }
			// else if ($bln == '06') { $bln = 'Juni'; }
			// else if ($bln == '07') { $bln = 'Juli'; }
			// else if ($bln == '08') { $bln = 'Agustus'; }
			// else if ($bln == '09') { $bln = 'September'; }
			// else if ($bln == '10') { $bln = 'Oktober'; }
			// else if ($bln == '11') { $bln = 'November'; }
			// else { $bln = 'Desember'; }
		?>
		{{ $tgl }} {{ $bln }} {{ $thn }}
	@else
		-
	@endif
	:
	{{ date('H') }}:{{ date('i') }}
</div> --}}
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

function ubahs($created) {
	$data = explode(' ',$created);
	$dates = $data[0];
	$times = $data[1];

	$tgl_ = explode('-',$dates);
	$thn = $tgl_[0]; $bln = $tgl_[1]; $tgl = $tgl_[2];

	$times_ = explode(':',$times);
	$jam = $times_[0];
	$menit = $times_[1];
	$second = explode('.',$times_[2]);
	$detik = $second[0];
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

	return $tgl . ' ' . $bln . ' ' . $thn . ' ' . $jam . ':' . $menit . ':' . $detik;
}
?>
</body>
</html>
