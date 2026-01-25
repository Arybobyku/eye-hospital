<table border="1">
	<tr>
		<td colspan="9" align="center">Laporan Pembelian Obat/Alkes</td>
	</tr>
	<tr>
		<td colspan="9" align="center">Periode {{ tglse($dari) }} sampai {{ tglse($ke) }}</td>
	</tr>
	@if ($nama_supplier != '-')
	<tr>
		<td colspan="9" align="center">{{ $nama_supplier }}</td>
	</tr>
	@endif
	<tr>
		<td>Tanggal</td>
		<td>Nama Vendor</td>
		<td>No Faktur</td>
		<td>Nama Obat</td>
		<td>Batch</td>
		<td>Expired</td>
		<td align="center">Jumlah</td>
		<td align="right">Harga/Satuan</td>
		<td align="center">Diskon</td>
		<td align="right">Harga/Satuan (After Diskon)</td>
	</tr>
	@foreach ($data as $row)
		<tr>
			<td>{{ tglse($row->tanggal_faktur) }}</td>
			<td>{{ $row->nama_supplier }}</td>
			<td>{{ $row->no_faktur }}</td>
			<td>{{ $row->nama }}</td>
			<td>{{ $row->batch }}</td>
			<td>{{ tglse($row->expired_date) }}</td>
			<td align="center">{{ $row->jumlah_kecil }} {{ $row->nama_satuan_kecil }}</td>
			<td align="center">{{ $row->harga_kecil }}/{{ $row->nama_satuan_kecil }}</td>
			<td align="right">{{ $row->jumlah_diskon }}</td>
			<td align="right">{{ $row->harga_kecil_diskon }}/{{ $row->nama_satuan_kecil }}</td>
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