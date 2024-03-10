<table border="1">
	<tr>
		<td colspan="9" align="center">Laporan Penjualan Obat/Alkes Apotek</td>
	</tr>
	<tr>
		<td colspan="9" align="center">Periode {{ tglse($dari) }} sampai {{ tglse($ke) }}</td>
	</tr>
	@if ($nama_dokter != '-')
	<tr>
		<td colspan="9" align="center">{{ $nama_dokter }}</td>
	</tr>
	@endif
	<tr>
		<td>Tanggal</td>
		<td>Waktu</td>
		<td>Nama Dokter</td>
		<td>Nama Pasien</td>
		<td>Nama Obat</td>
		<td align="center">Jumlah</td>
		<td align="center">Satuan</td>
		<td align="right">HJA Resep</td>
		<td align="right">Total</td>
	</tr>
	@foreach ($data as $row)
		<tr>
			<td>{{ tglse($row->tanggal) }}</td>
			<td>{{ $row->waktu }}</td>
			<td>{{ $row->nama_dokter }}</td>
			<td>{{ $row->nama_pasien }}</td>
			<td>{{ $row->nama_obat }}</td>
			<td align="center">{{ $row->jumlah_kecil }}</td>
			<td align="center">{{ $row->nama_satuan_kecil }}</td>
			<td align="right">{{ $row->hja_resep }}</td>
			<td align="right">{{ $row->total }}</td>
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