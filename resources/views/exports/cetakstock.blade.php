<table border="1">
	<tr>
		<td colspan="6" align="center">Laporan Data Stock Obat/Alkes {{ $nama }}</td>
	</tr>
	<tr>
		<td colspan="6" align="left">Tanggal : {{ tglse(date('Y-m-d')) }}</td>
	</tr>
	<tr>
		<td>Nama Obat</td>
		<td>Jenis</td>
		<td>Kategori</td>
		<td>Formularium</td>
		<td>Golongan</td>
		<td align="right">Jumlah</td>
	</tr>
	@foreach ($data as $row)
		<tr>
			<td>{{ $row->nama }}</td>
			<td>{{ $row->jenis }}</td>
			<td>{{ $row->kategori }}</td>
			<td>{{ $row->formularium }}</td>
			<td>{{ $row->golongan }}</td>
			<td align="right">{{ $row->jumlah_kecil }} {{ $row->nama_satuan_kecil }}/{{ $row->nama_satuan_besar }}</td>
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