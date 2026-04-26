<table border="1">
	<tr>
		<td colspan="18">Laporan Tindakan Medis RS Prima Vision</td>
	</tr>
	<tr>
		<td colspan="18">Periode {{ tglse($dari) }} sampai {{ tglse($ke) }}</td>
	</tr>
	@if ($nama_dokter != '-')
	<tr>
		<td>Nama Dokter</td>
		<td colspan="17">: {{ $nama_dokter }}</td>
	</tr>
	@endif
	@if ($carabayar_nama != '-')
	<tr>
		<td>Metode Pembayaran</td>
		<td colspan="17">: {{ $carabayar_nama }}
			<?php
					if ($nama_asuransi != '-') {
						echo ' - '.$nama_asuransi;
					}
			?>
		</td>
	</tr>
	@endif
	@if ($nama_layanan != '-')
	<tr>
		<td>Nama Layanan</td>
		<td colspan="17">: {{ $nama_layanan }}</td>
	</tr>
	@endif
	<tr>
		<td>Tanggal</td>
		<td>No. Pendaftaran</td>
		<td>Jenis Kunjungan</td>
		<td>No Kwitansi</td>
		<td>Nama Pasien</td>
		<td>No. Rekam Medik</td>
		<td>Dokter yang menangani</td>
		{{-- <td>Cara Masuk</td> --}}
		<td>Metode Pembayaran</td>
		{{-- <td>Diperiksa Pada Pukul</td> --}}
		{{-- <td>Selesai Pada Pukul</td> --}}
		<td>Tanggal Pembayaran</td>
		<td>Pembayaran Dilakukan Melalui</td>
		<td>Nama Tindakan</td>
		<td>Tarif</td>
		<td>Diskon Rp</td>
		<td>Diskon Persen</td>
		<td>Diskon Global</td>
		<td>Total</td>
	</tr>
	@foreach ($data as $row)
		<tr>
			<td>{{ tglse($row->tanggal) }}</td>
			<td>{{ $row->kode }}{{ $row->nomor }}</td>
			<td>{{ $row->jenis }}</td>
			<td>{{ $row->no_kwitansi }}</td>
			<td>{{ $row->nama_pasien }}</td>
			<td>{{ $row->rekam_medis }}</td>
			<td>{{ $row->nama_dokter }}</td>
			{{-- <td>{{ $row->cara_masuk }}</td> --}}
			<td>{{ $row->carabayar_nama }} 
			<?php
					if ($row->nama_asuransi != '' && $row->nama_asuransi != 'Silahkan Pilih') {
						echo ' - '.$row->nama_asuransi;
					}
			?>
			</td>
			{{-- <td>{{ $row->dokter_jam_periksa }}</td> --}}
			{{-- <td>{{ $row->kasir_jam_selesai }}</td> --}}
			<td>{{ $row->tanggal_bayar }}</td>
			<td>{{ $row->metode_pembayaran }}</td>
			<td>{{ $row->nama_layanan }}</td>
			<td>{{ $row->tarif }}</td>
			<td>{{ $row->diskon_rp }}</td>
			<td>{{ $row->diskon_persen }}</td>
			<td>{{ $row->registrasi_diskon_persen  }}</td>
			<td>{{ $row->registrasi_diskon_persen > 0 ? $row->total - ($row->total * ($row->registrasi_diskon_persen / 100) ) :   $row->total }}</td>
			{{-- <td>{{ $row->total }}</td> --}}
		</tr>
	@endforeach
	
</table>

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

?>