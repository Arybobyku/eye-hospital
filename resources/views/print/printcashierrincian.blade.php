<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Invoice</title>
    <style>
    @page { margin: 5px;  }
		body { margin: 10px }
    table.header-top tr td {
			padding: 5px 0;
		}
		
    </style>
</head>
<body>

<?php $fullpath = storage_path('app/public/header.png');  ?>

	<table style="width: 100%; font-size: 10.5pt; border-bottom: 1px solid #000; margin-bottom: 5px">
		<tr>
			<td style="width: 58%">
				<table class="header-top">
					<tr>
						<td style="width: 28%">Order No.</td>
						<td>: {{ $registrasi->no_invoice }}</td>
					</tr>
					<tr>
						<td>Jenis Pembayaran</td>
						<td>: 
							@if ($registrasi->carabayar_nama == 'Umum')
								 Pembayaran Pribadi
							@else
								{{ $registrasi->carabayar_nama }}
								@if ($registrasi->nama_asuransi != '' && $registrasi->nama_asuransi != 'Silahkan Pilih')
									- {{ $registrasi->nama_asuransi }}
								@endif
							@endif
						</td>
					</tr>
					<tr>
						<td>Banyaknya</td>
						<td>:
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
							@if ($registrasi->diskon_rp != 0)
							<?php 
								$diskonGlobalTop = $registrasi->diskon_rp; 
								$totalDiskonGlobalTop = $diskonGlobalTop ; 
								// $grandtotal2 = $grandtotal - $diskonGlobal;
								$grandtotaltop = $grandtotaltop - $totalDiskonGlobalTop; 
							?>
							@endif
							Rp. {{ number_format($grandtotaltop) }}
						</td>
					</tr>
					<tr>
						<td>Terbilang</td>
						<td>: 
							<i style="text-transform: uppercase">"# {{ terbilang($grandtotaltop) }} Rupiah #"</i>
						</td>
					</tr>
				</table>
			</td>
			<td valign="top">
				<table class="header-top">
					<tr>
						<td>Tanggal Cetak</td>
						<td>: {{ tglse($registrasi->tanggal_bayar) }}</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td>Tanggal Selesai Periksa</td>
					<td>: {{ !empty($honor[0]->created_at) ? ubahDate($honor[0]->created_at) : (!empty($rawatjalan[0]->created_at) ? ubahDate($rawatjalan[0]->created_at) : (!empty($resep_alkes[0]->created_at) ? ubahDate($resep_alkes[0]->created_at) : 'Date not available')) }} </td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table style="width: 100%; font-size: 10.5pt; border-bottom: 1px solid #000; margin-bottom: 16px">
		<tr>
			<td style="width: 58%">
				<table class="header-top">
					<tr>
						<td style="width: 28%">No. Rekam Medik</td>
						<td>: {{ $registrasi->rekam_medis }}</td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>: {{ $pasien->sebutan }} <span style="text-transform: uppercase">{{ $pasien->nama }}</span></td>
					</tr>
					<tr>
						<td>No. Pendaftaran</td>
						<td>: {{ $registrasi->kode }} {{ $registrasi->nomor }}</td>
					</tr>
					<tr>
						<td>Umur/Tanggal Lahir</td>
						<td>: {{ umurs($registrasi->tanggal_lahir) }}/{{ tglse($registrasi->tanggal_lahir) }}</td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td style="text-transform: uppercase">: {{ $pasien->alamat }}</td>
					</tr>
				</table>
			</td>
			<td valign="top">
				<table class="header-top">
					<tr>
						<td>Tanggal Masuk</td>
						<td>: {{ tglse($registrasi->tanggal) }}</td>
					</tr>
					<tr>
						<td>Tipe Kunjungan</td>
						<td>: {{ $registrasi->jenis }}</td>
					</tr>
					<tr>
						<td>Poliklinik</td>
						<td>: Klinik Penyakit Mata</td>
					</tr>
					<tr>
						<td>Dokter</td>
						<td>: {{ $registrasi->nama_dokter }}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table style="width: 100%; text-align: left; font-size: 10.7pt;" cellpadding="0" cellspacing="0">
		<thead>
			<tr style="border-bottom: 1px solid #000">
				<th colspan="2" align="left" style="padding: 5px 3px 18px; width: 35%">Uraian</th>
				<th align="center" style="padding: 5px 3px 18px; width: 26%">Tgl Transaksi</th>
				<th align="center" style="padding: 5px 3px 18px; width: 9%">Harga</th>
				<th align="center" style="padding: 5px 3px 18px;  width: 4%">Qty</th>
				<th align="center" style="padding: 5px 3px 18px; width: 10%">Disc(Rp)</th>
				<th align="center" style="padding: 5px 3px 18px; width: 6%">Disc(%)</th>
				<th align="right" style="padding: 5px 3px 18px; width: 10%">Total (Rp.)</th>
			</tr>
		</thead>
		<tbody>
			

			<?php $grandtotal = 0; ?>
			
			@if(count($administrasi) > 0)
				<tr>
					<td colspan="8" style="padding: 13px 8px 11px"><b>Biaya Administrasi</b></td>
				</tr>

				<?php $nomor = 1; $subtotal = 0; ?>
				
				@foreach ($administrasi as $item)
					
					<tr>
						<td align="center" style="padding: 10px 2px; width: 5%" valign="center">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 2px;">
							@if ($item->nama_layanan == 'Administrasi Rawat Jalan (pl)')
								Biaya Pendaftaran + Adm Rawat Jalan (pl)
							@elseif($item->nama_layanan == 'Administrasi Rawat Jalan (pb)')
								Biaya Pendaftaran + Adm Rawat Jalan (pb)
							@endif
						</td>
						<td align="center" style="padding: 10px 2px; width: 17%" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ $item->qty}}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ number_format($item->diskon_rp) }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ $item->diskon_persen }}</td>
						<td align="right" style="padding: 10px 2px;" valign="top">{{ number_format($item->total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $subtotal += $item->total; ?>
				@endforeach

				<tr style="border-bottom: 1px solid #343224">
					<td style="padding: 12px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				<?php $grandtotal += $subtotal; ?>
			@endif

			@if(count($honor) > 0)
				<tr>
					<td colspan="8" style="padding: 13px 8px 11px"><b>Honor Konsultasi Rawat Jalan</b></td>
				</tr>

				<?php $nomor = 1; $subtotal = 0; ?>
				
				@foreach ($honor as $item)
					
					<tr>
						<td align="center" style="padding: 10px 2px; width: 5%" valign="center">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 2px;">
							{{ $item->nama_layanan }}<br />
							{{ $item->nama_dokter }}
						</td>
						<td align="center" style="padding: 10px 2px; width: 17%" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ $item->qty}}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ number_format($item->diskon_rp) }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ $item->diskon_persen }}</td>
						<td align="right" style="padding: 10px 2px;" valign="top">{{ number_format($item->total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $subtotal += $item->total; ?>
				@endforeach

				<tr style="border-bottom: 1px solid #343224">
					<td style="padding: 12px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				<?php $grandtotal += $subtotal; ?>
			@endif

			@if(count($rawatjalan) > 0)

				<?php $nomor = 1; $subtotal = 0; $dokter = '' ?>
				
				@foreach ($rawatjalan as $item)

					@if ($dokter != $item->nama_dokter)
					<tr>
						<td colspan="8" style="padding: 13px 8px 11px"><b>Tindakan Rawat Jalan</b> : <b>{{ $item->nama_dokter }}</b></td>
					</tr>
					<?php $dokter = $item->nama_dokter; $nomor = 1; ?>
					@endif

					<tr>
						<td align="center" style="padding: 10px 2px; width: 3%">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 2px;">{{ $item->nama_layanan }}</td>
						<td align="center" style="padding: 10px 2px; width: 17%" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ $item->jumlah_nama_layanan }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ number_format($item->total_diskon_rp) }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ $item->total_diskon_persen }}</td>
						<td align="right" style="padding: 10px 2px;" valign="top">{{ number_format($item->total_total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $subtotal += $item->total_total; ?>
				@endforeach

				<tr style="border-bottom: 1px solid #343224">
					<td style="padding: 12px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>

				<?php $grandtotal += $subtotal; ?>
			@endif

			@if(count($honorbedah) > 0)

				<?php $nomor = 1; $subtotal = 0; $dokter = '' ?>
				
				@foreach ($honorbedah as $item)

					@if ($nomor == 1)
					<tr>
						<td colspan="8" style="padding: 13px 8px 11px"><b>{{ $item->jenis }}</b></td>
					</tr>
					@endif

					<tr>
						<td align="center" style="padding: 10px 2px; width: 3%">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 2px;">{{ $item->nama_layanan }}</td>
						<td align="center" style="padding: 10px 2px; width: 17%" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ $item->qty}}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ number_format($item->diskon_rp) }}</td>
						<td align="center" style="padding: 10px 2px" valign="top">{{ $item->diskon_persen }}</td>
						<td align="right" style="padding: 10px 2px;" valign="top">{{ number_format($item->total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $subtotal += $item->total; ?>
				@endforeach

				<tr style="border-bottom: 1px solid #343224">
					<td style="padding: 12px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>

				<?php $grandtotal += $subtotal; ?>
			@endif

			@if($collection->count() > 0)


				@foreach ($collection as $item)
					<?php $nomor = 1; $subtotal = 0; ?>
					
					@foreach ($item->data as $row)
							@if ($nomor == 1) 
								<tr>
									<td colspan="8" style="padding: 13px 8px 11px"><b>{{ $row->jenis }}</b></td>
								</tr>
							@endif
							<tr>
								<td align="center" style="padding: 10px 2px; width: 3%">{{ $nomor }}.</td>
								<td align="left" style="padding: 10px 2px;">{{ $row->nama_layanan }}</td>
								<td align="center" style="padding: 10px 2px; width: 17%" valign="top">{{ ubahDate($row->created_at) }}</td>
								<td align="center" style="padding: 10px 2px" valign="top">{{ number_format($row->tarif) }}</td>
								<td align="center" style="padding: 10px 2px" valign="top">{{ $row->qty}}</td>
								<td align="center" style="padding: 10px 2px" valign="top">{{ number_format($row->diskon_rp) }}</td>
								<td align="center" style="padding: 10px 2px" valign="top">{{ $row->diskon_persen }}</td>
								<td align="right" style="padding: 10px 2px;" valign="top">{{ number_format($row->total) }}</td>
							</tr>
							<?php $nomor += 1; ?>
							<?php $subtotal += $row->total; ?>
					@endforeach

					<tr style="border-bottom: 1px solid #343224">
						<td style="padding: 12px 5px; font-weight: bold;" colspan="7">Sub Total</td>
						<td align="right" style="padding: 12px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
					</tr>
	
					<?php $grandtotal += $subtotal; ?>

				@endforeach

			@endif

			@if(count($room) > 0 && $collection->count() < 1)

				<?php $nomor = 1; $subtotal = 0; ?>

				<tr>
					<td colspan="8" style="padding: 13px 8px 11px"><b>Room</b></td>
				</tr>
				
				@foreach ($room as $item)
					
					<tr>
						<td align="center" style="padding: 10px 3px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 3px;">{{ $item->nama_layanan }}</td>
						<td align="center" style="padding: 10px 3px; width: 17%" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 3px" valign="top">{{ number_format($item->tarif) }}</td>
						<td align="center" style="padding: 10px 3px" valign="top">{{ $row->qty}}</td>
						<td align="center" style="padding: 10px 3px" valign="top">{{ number_format($item->diskon_rp) }}</td>
						<td align="center" style="padding: 10px 3px" valign="top">{{ $item->diskon_persen }}</td>
						<td align="right" style="padding: 10px 3px;" valign="top">{{ number_format($item->total) }}</td>
					</tr>
				<?php $nomor++; ?>

				<?php $subtotal += $item->total; ?>
				@endforeach

				<tr style="border-bottom: 1px solid #343224">
					<td style="padding: 12px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
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
				<?php 
					//$nomor++; 
				?>

				<?php 
					//$grandtotal += $item->total; 
				?>
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
				<?php 
					//$nomor++; 
				?>

				<?php 
					//$grandtotal += $item->total; 
				?>
				@endforeach
			@endif --}}

			@if (count($resep_obat) > 0 || count($resep_alkes) > 0) 
				<tr>
					<td colspan="8" style="padding: 13px 8px 11px"><b>Farmasi Pelayanan</b></td>
				</tr>
			@endif
			@if(count($resep_obat) > 0)

				<?php $nomor = 1; $subtotal = 0; ?>

				<tr>
					<td colspan="8" style="padding: 13px 8px 11px">- <i>Obat-obatan</i></td>
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
						<td align="center" style="padding: 10px 2px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 2px;">{{ $item->nama_obat }}</td>
						<td align="center" style="padding: 10px 2px; width: 17%" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 2px">{{ number_format($item->hja_resep) }}</td>
						<td align="center" style="padding: 10px 2px">{{ $item->jumlah_kecil }}</td>
						<td align="right" style="padding: 10px 2px;" colspan="3">{{ number_format($item->total) }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"></td> --}}
					</tr>
					<?php $nomor++; ?>

					<?php $subtotal += $item->total; ?>
				@endforeach
				@if (count($resep_alkes) > 0)
				<tr>
					<td style="padding: 12px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				@else
					<tr>
						<td style="padding: 12px 5px; font-weight: bold;" colspan="5">Sub Total</td>
						<td style="padding: 12px 5px;" align="center">{{ $diskon_rp }}</td>
						<td style="padding: 12px 5px;" align="center">{{ $diskon_persen }}</td>
						<td align="right" style="padding: 12px 5px; font-weight: bold;">
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

							<?php
								if ($obatan) {
									$sementara = $obatan->total;
								}
							?>
							{{ number_format($sementara) }}
							<?php $subtotal = $sementara; ?>
							<?php 
								//$grandtotal += $sementara;
							 ?>
						</td>
					</tr>
				@endif
				<?php 
					$grandtotal += $subtotal; 
				?>
			@endif

			@if(count($resep_alkes) > 0)

			<?php $nomor = 1; $subtotal = 0; ?>

				<tr>
					<td colspan="8" style="padding: 13px 8px 11px">- <i>Alkes</i></td>
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
						<td align="center" style="padding: 10px 2px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 2px;">{{ $item->nama_obat }}</td>
						<td align="center" style="padding: 10px 2px; width: 17%" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 2px">{{ number_format($item->hja_resep) }}</td>
						<td align="center" style="padding: 10px 2px">{{ $item->jumlah_kecil }}</td>
						<td align="right" style="padding: 10px 2px;" colspan="3">{{ number_format($item->total) }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"></td> --}}
					</tr>
					<?php $nomor++; ?>

					<?php $subtotal += $item->total; ?>
				@endforeach

				<tr>
					<td style="padding: 12px 5px; font-weight: bold;" colspan="5">Sub Total</td>
					<td style="padding: 12px 5px;" align="center">{{ $diskon_rp }}</td>
					<td style="padding: 12px 5px;" align="center">{{ $diskon_persen }}</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">
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
						<?php
							// if ($obatan) {
							// 	$sementara = $obatan->total;
							// }
						?>
						{{ number_format($sementara) }}
						<?php $subtotal = $sementara; ?>
						<?php $grandtotal += $sementara; ?>
					</td>
				</tr>
				<?php 
					// $grandtotal += $subtotal; 
				?>
			@endif
			
			@if(count($resepracikan) > 0)
				<?php $nomor = 1; $subtotal = 0; ?>
				<tr>
					<td colspan="8" style="padding: 13px 8px 11px">- <i>Obat-Obatan (Racikan)</i></td>
				</tr>
				<?php $subtotal += $obatracikan->total; ?>
				
				@foreach ($resepracikan as $item)
					<tr>
						<td align="center" style="padding: 10px 2px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 2px;" >{{ $item->label }}</td>
						<td align="center" style="padding: 10px 2px; width: 17%" colspan="2" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 2px">{{ $item->jumlah }} {{ $item->kemasan }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"><b>{{ number_format($item->total) }}</b></td> --}}
						<td align="right" style="padding: 10px 2px;" colspan="3"></td>
					</tr>
					<?php $informasi = json_decode($item->informasi) ?>
					@foreach ($informasi as $itemin)
					<tr>
						<td align="center" style="padding: 10px 2px; width: 5%">@</td>
						<td align="left" style="padding: 10px 2px;" colspan="2">{{ $itemin->nama }}</td>
						<td align="center" style="padding: 10px 2px">{{ number_format($itemin->hja_resep) }}</td>
						<td align="center" style="padding: 10px 2px">{{ $itemin->jumlah_kecil }}</td>
						<td align="right" style="padding: 10px 2px;" colspan="3">{{ number_format($itemin->total) }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"></td> --}}
					</tr>
					@endforeach
				<?php $nomor++; ?>

				@endforeach

				<tr>
					<td style="padding: 12px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				<?php $grandtotal += $subtotal; ?>
			@endif

			@if (count($resep_obat_bedah) > 0 || count($resep_alkes_bedah) > 0) 
				<tr>
					<td colspan="8" style="padding: 13px 8px 11px"><b>Farmasi Pelayanan Pasca Bedah</b></td>
				</tr>
			@endif
			@if(count($resep_obat_bedah) > 0)

				<?php $nomor = 1; $subtotal = 0; ?>

				<tr>
					<td colspan="8" style="padding: 13px 8px 11px">- <i>Obat-obatan Pasca Bedah</i></td>
				</tr>
				{{-- <tr>
					<td align="left" colspan="4" style="padding: 10px 8px"><b>Farmasi Pelayanan</b></td>
					<td align="center" style="padding: 10px 8px">{{ number_format($obatan->diskon_rp) }}</td>
					<td align="center" style="padding: 10px 8px">{{ $obatan->diskon_persen }}</td>
					<td align="right" style="padding: 10px 8px"><b style="color: #640404">{{ number_format($obatan->total) }}</b></td>
				</tr> --}}
				<?php $nomor = 1; ?>
				@foreach ($resep_obat_bedah as $item)
					<tr>
						<td align="center" style="padding: 10px 2px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 2px;">{{ $item->nama_obat }}</td>
						<td align="center" style="padding: 10px 2px; width: 17%" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 2px">{{ number_format($item->hja_resep) }}</td>
						<td align="center" style="padding: 10px 2px">{{ $item->jumlah_kecil }}</td>
						<td align="right" style="padding: 10px 2px;" colspan="3">{{ number_format($item->total) }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"></td> --}}
					</tr>
					<?php $nomor++; ?>

					<?php $subtotal += $item->total; ?>
				@endforeach
				@if (count($resep_alkes_bedah) > 0)
				<tr>
					<td style="padding: 12px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				@else
					<tr>
						<td style="padding: 12px 5px; font-weight: bold;" colspan="5">Sub Total</td>
						<td style="padding: 12px 5px;" align="center">{{ $diskon_rp }}</td>
						<td style="padding: 12px 5px;" align="center">{{ $diskon_persen }}</td>
						<td align="right" style="padding: 12px 5px; font-weight: bold;">
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

							<?php
								// if ($obatan) {
								// 	$sementara = $obatan->total;
								// }
							?>
							{{ number_format($sementara) }} 
							<?php $subtotal = $sementara; ?>
							<?php $grandtotal += $sementara; ?>
						</td>
					</tr>
				@endif
				<?php 
					//$grandtotal += $subtotal; 
				?>
			@endif

			@if(count($resep_alkes_bedah) > 0)

			<?php $nomor = 1; $subtotal = 0; ?>

				<tr>
					<td colspan="8" style="padding: 13px 8px 11px">- <i>Alkes Pasca Bedah</i></td>
				</tr>
				{{-- <tr>
					<td align="left" colspan="4" style="padding: 10px 8px"><b>Farmasi Pelayanan</b></td>
					<td align="center" style="padding: 10px 8px">{{ number_format($obatan->diskon_rp) }}</td>
					<td align="center" style="padding: 10px 8px">{{ $obatan->diskon_persen }}</td>
					<td align="right" style="padding: 10px 8px"><b style="color: #640404">{{ number_format($obatan->total) }}</b></td>
				</tr> --}}
				<?php $nomor = 1; ?>
				@foreach ($resep_alkes_bedah as $item)
					<tr>
						<td align="center" style="padding: 10px 2px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 2px;">{{ $item->nama_obat }}</td>
						<td align="center" style="padding: 10px 2px; width: 17%" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 2px">{{ number_format($item->hja_resep) }}</td>
						<td align="center" style="padding: 10px 2px">{{ $item->jumlah_kecil }}</td>
						<td align="right" style="padding: 10px 2px;" colspan="3">{{ number_format($item->total) }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"></td> --}}
					</tr>
					<?php $nomor++; ?>

					<?php $subtotal += $item->total; ?>
				@endforeach

				<tr>
					<td style="padding: 12px 5px; font-weight: bold;" colspan="5">Sub Total</td>
					<td style="padding: 12px 5px;" align="center">{{ $diskon_rp }}</td>
					<td style="padding: 12px 5px;" align="center">{{ $diskon_persen }}</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">
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
						<?php
							if ($obatan) {
								$sementara = $obatan->total;
							}
						?>
						{{ number_format($sementara) }}
						<?php $subtotal = $sementara; ?>
						<?php $grandtotal += $sementara; ?>
					</td>
				</tr>
				<?php 
					// $grandtotal += $subtotal; 
				?>
			@endif
			
			@if(count($resepracikanbedah) > 0)
				<?php $nomor = 1; $subtotal = 0; ?>
				<tr>
					<td colspan="8" style="padding: 13px 8px 11px">- <i>Obat-Obatan (Racikan) Pasca Bedah</i></td>
				</tr>
				<?php $subtotal += $obatracikanbedah->total; ?>
				
				@foreach ($resepracikanbedah as $item)
					<tr>
						<td align="center" style="padding: 10px 2px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 2px;" >{{ $item->label }}</td>
						<td align="center" style="padding: 10px 2px; width: 17%" colspan="2" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 2px">{{ $item->jumlah }} {{ $item->kemasan }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"><b>{{ number_format($item->total) }}</b></td> --}}
						<td align="right" style="padding: 10px 2px;" colspan="3"></td>
					</tr>
					<?php $informasi = json_decode($item->informasi) ?>
					@foreach ($informasi as $itemin)
					<tr>
						<td align="center" style="padding: 10px 2px; width: 5%">@</td>
						<td align="left" style="padding: 10px 2px;" colspan="2">{{ $itemin->nama }}</td>
						<td align="center" style="padding: 10px 2px">{{ number_format($itemin->hja_resep) }}</td>
						<td align="center" style="padding: 10px 2px">{{ $itemin->jumlah_kecil }}</td>
						<td align="right" style="padding: 10px 2px;" colspan="3">{{ number_format($itemin->total) }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"></td> --}}
					</tr>
					@endforeach
				<?php $nomor++; ?>

				@endforeach

				<tr>
					<td style="padding: 12px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				<?php $grandtotal += $subtotal; ?>
			@endif
			
			@if (count($resep_obat_tambahan) > 0 || count($resep_alkes_tambahan) > 0) 
			<tr>
				<td colspan="8" style="padding: 13px 8px 11px"><b>Farmasi Pelayanan Tambahan</b></td>
			</tr>
			@endif
			@if(count($resep_obat_tambahan) > 0)

				<?php $nomor = 1; $subtotal = 0; ?>

				<tr>
					<td colspan="8" style="padding: 13px 8px 11px">- <i>Obat/Vit Tambahan</i></td>
				</tr>
				{{-- <tr>
					<td align="left" colspan="4" style="padding: 10px 8px"><b>Farmasi Pelayanan</b></td>
					<td align="center" style="padding: 10px 8px">{{ number_format($obatan->diskon_rp) }}</td>
					<td align="center" style="padding: 10px 8px">{{ $obatan->diskon_persen }}</td>
					<td align="right" style="padding: 10px 8px"><b style="color: #640404">{{ number_format($obatan->total) }}</b></td>
				</tr> --}}
				<?php $nomor = 1; ?>
				@foreach ($resep_obat_tambahan as $item)
					<tr>
						<td align="center" style="padding: 10px 2px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 2px;">{{ $item->nama_obat }}</td>
						<td align="center" style="padding: 10px 2px; width: 17%" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 2px">{{ number_format($item->hja_resep) }}</td>
						<td align="center" style="padding: 10px 2px">{{ $item->jumlah_kecil }}</td>
						<td align="right" style="padding: 10px 2px;" colspan="3">{{ number_format($item->total) }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"></td> --}}
					</tr>
					<?php $nomor++; ?>

					<?php $subtotal += $item->total; ?>
				@endforeach
				@if (count($resep_alkes_tambahan) > 0)
				<tr>
					<td style="padding: 12px 5px; font-weight: bold;" colspan="7">Sub Total</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">{{ number_format($subtotal) }}</td>
				</tr>
				@else
					<tr>
						<td style="padding: 12px 5px; font-weight: bold;" colspan="5">Sub Total</td>
						<td style="padding: 12px 5px;" align="center">{{ $diskon_rp }}</td>
						<td style="padding: 12px 5px;" align="center">{{ $diskon_persen }}</td>
						<td align="right" style="padding: 12px 5px; font-weight: bold;">
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

							<?php
								if ($obatantambahan) {
									$sementara = $obatantambahan->total;
								}
							?>
							{{ number_format($sementara) }}
							<?php $subtotal = $sementara; ?>
							<?php $grandtotal += $sementara; ?>
						</td>
					</tr>
				@endif
				<?php 
					//$grandtotal += $subtotal; 
				?>
			@endif

			@if(count($resep_alkes_tambahan) > 0)

			<?php $nomor = 1; $subtotal = 0; ?>

				<tr>
					<td colspan="8" style="padding: 13px 8px 11px">- <i>Alkes</i></td>
				</tr>
				{{-- <tr>
					<td align="left" colspan="4" style="padding: 10px 8px"><b>Farmasi Pelayanan</b></td>
					<td align="center" style="padding: 10px 8px">{{ number_format($obatan->diskon_rp) }}</td>
					<td align="center" style="padding: 10px 8px">{{ $obatan->diskon_persen }}</td>
					<td align="right" style="padding: 10px 8px"><b style="color: #640404">{{ number_format($obatan->total) }}</b></td>
				</tr> --}}
				<?php $nomor = 1; ?>
				@foreach ($resep_alkes_tambahan as $item)
					<tr>
						<td align="center" style="padding: 10px 2px; width: 5%">{{ $nomor }}.</td>
						<td align="left" style="padding: 10px 2px;">{{ $item->nama_obat }}</td>
						<td align="center" style="padding: 10px 2px; width: 17%" valign="top">{{ ubahDate($item->created_at) }}</td>
						<td align="center" style="padding: 10px 2px">{{ number_format($item->hja_resep) }}</td>
						<td align="center" style="padding: 10px 2px">{{ $item->jumlah_kecil }}</td>
						<td align="right" style="padding: 10px 2px;" colspan="3">{{ number_format($item->total) }}</td>
						{{-- <td align="right" style="padding: 5px 7px;" colspan="3"></td> --}}
					</tr>
					<?php $nomor++; ?>

					<?php $subtotal += $item->total; ?>
				@endforeach

				<tr>
					<td style="padding: 12px 5px; font-weight: bold;" colspan="5">Sub Total</td>
					<td style="padding: 12px 5px;" align="center">{{ $diskon_rp }}</td>
					<td style="padding: 12px 5px;" align="center">{{ $diskon_persen }}</td>
					<td align="right" style="padding: 12px 5px; font-weight: bold;">
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
						<?php
							// if ($obatantambahan) {
							// 	$sementara = $obatantambahan->total;
							// }
						?>
						{{ number_format($sementara) }}
						<?php $subtotal = $sementara; ?>
						<?php $grandtotal += $sementara; ?>
					</td>
				</tr>
				<?php 
					// $grandtotal += $subtotal; 
				?>
			@endif
			<tr>
				<td colspan="8"><hr /></td>
			</tr>

			<?php $last = $grandtotal; ?>

			@if ($registrasi->panjar == '0' && $registrasi->cover_asuransi == '0')
				@if ($registrasi->diskon_rp != 0)
					<?php 
						$last = $grandtotaltop + $totalDiskonGlobalTop + $diskon; 
					?>
				@endif
				<tr >
					<td colspan="6" align="left" style="padding: 6px 5px; width: 65%;"><b>Grand Total</b></td>
					<td colspan="2" align="right" style="padding: 6px 5px;"><b>Rp. {{ number_format($last) }}</b></td>
				</tr>
			@endif

			

			@if ($registrasi->panjar != '0' || $registrasi->cover_asuransi != '0')
				@if ($registrasi->panjar != '0')
					<?php $grandtotal = $grandtotal - $registrasi->panjar; ?>
					<tr>
						<td colspan="6" align="left" style="padding: 6px 5px; width: 65%"><b>Biaya Panjar</b></td>
						<td colspan="2" align="right" style="padding: 6px 5px"><b>Rp. {{ number_format($registrasi->panjar) }}</b></td>
					</tr>
				@endif

				@if ($registrasi->cover_asuransi != '0')
					<?php $grandtotal = $grandtotal - $registrasi->cover_asuransi; ?>
					<tr>
						<td colspan="6" align="left" style="padding: 6px 5px; width: 65%"><b>Nominal Asuransi</b></td>
						<td colspan="2" align="right" style="padding: 6px 5px"><b>Rp. {{ number_format($registrasi->cover_asuransi) }}</b></td>
					</tr>
				@endif
				<?php $last = $last + $diskon ?>
				<tr>
					<td colspan="6" align="left" style="padding: 6px 5px; width: 65%"><b>Grand Total</b></td>
					<td colspan="2" align="right" style="padding: 6px 5px"><b>Rp. {{ number_format($last) }}</b></td>
				</tr>
				
			@endif
			
			@if ($diskon != 0 || $registrasi->diskon_rp != 0)
				<?php 
					$diskonGlobal = $registrasi->diskon_rp; 
					$totalDiskonGlobal = $diskonGlobal + $diskon; 
					$grandtotal2 = $grandtotal - $diskonGlobal;
				?>
			@if ($diskon != 0)

				<tr >
					<td colspan="6" align="left" style="padding: 4px 7px; width: 65%;"><b>Diskon Item</b></td>
					<td colspan="2" align="right" style="padding: 4px 7px;"><b>Rp. {{ number_format($diskon) }}</b></td>
				</tr>
			@endif
			@if ($diskonGlobal != 0)

				<tr >
					<td colspan="6" align="left" style="padding: 4px 7px; width: 65%;"><b>Diskon Global</b></td>
					<td colspan="2" align="right" style="padding: 4px 7px;"><b>Rp. {{ number_format($diskonGlobal) }}</b></td>
				</tr>
				@endif
				<tr>


					<td colspan="6" align="left" style="padding: 4px 7px; width: 65%;"><b>Total Diskon</b></td>
					<td colspan="2" align="right" style="padding: 4px 7px;"><b>Rp. {{ number_format($totalDiskonGlobal) }}</b></td>
				</tr>
				<tr >
					<td colspan="6" align="left" style="padding: 4px 7px; width: 65%;"><b>Total Pembayaran</b></td>
					<td colspan="2" align="right" style="padding: 4px 7px;"><b>Rp. {{ number_format($grandtotaltop) }}</b></td>
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
				{{-- <tr>
					<td colspan="2" align="left" style="padding: 4px 7px; width: 65%"><b>Total Pembayaran</b></td>
					<td align="right" style="padding: 4px 7px"><b>Rp. {{ number_format($grandtotal) }}</b></td>
				</tr> --}}
				{{-- <tr>
					<td colspan="6" align="left" style="padding: 4px 7px; width: 65%"><b>Dibayarkan pasien</b></td>
					<td colspan="2" align="right" style="padding: 4px 7px"><b>Rp. {{ number_format($grandtotal) }}</b></td>
				</tr> --}}
				@if (($registrasi->apakah_paket == 'Ya' || $registrasi->apakah_paket == 'ya') && $registrasi->cover_asuransi != 0)
					<tr>
						<td colspan="6" align="left" style="padding: 4px 7px; width: 65%"><b>Dibayarkan pasien</b></td>
						<td colspan="2" align="right" style="padding: 4px 7px"><b>Rp. {{ number_format($grandtotal2 ?? $grandtotal) }}</b></td>
					</tr>
				@elseif (($registrasi->apakah_paket == 'Tidak' || $registrasi->apakah_paket == 'tidak') && $registrasi->cover_asuransi != 0)
					<tr>
						<td colspan="6" align="left" style="padding: 4px 7px; width: 65%"><b>Dibayarkan pasien</b></td>
						<td colspan="2" align="right" style="padding: 4px 7px"><b>Rp. {{ number_format($grandtotal2 ?? $grandtotal) }}</b></td>
					</tr>
				@endif
			@endif

			<tr>
				<td style="width: 31%" colspan="2">&nbsp;</td>
				<td style="width: 31%" colspan="2">&nbsp;</td>
				<td style="width: 37%; font-size: 10pt" colspan="4" align="center">
					<br />
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
					<br />
					<div style="padding-top: 7px; font-size: 10pt">Kasir</div>
					<br /><br /><br /><br /><br />
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

function ubahDate($created) {
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

	return $tgl . ' ' . $bln . ' ' . $thn;
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
