<table border="1">
	<tr>
		<td colspan="9" align="center">Laporan Stock Opname Obat/Alkes Apotek</td>
	</tr>
	<tr>
		<td colspan="9" align="center">Periode Bulan {{ $bulan }} {{ $tahun }}</td>
	</tr>
	<tr>
		<td>Tanggal</td>
		<td>Nama Obat</td>
		<td>Jenis</td>
		<td align="center">Volume Sistem</td>
		<td align="center">Volumen Fisik</td>
		<td align="right">Harga Satuan</td>
		<td align="right">Harga Netto</td>
	</tr>
	@foreach ($data as $row)
		<tr>
			<td>{{ tglse($row->created_at) }}</td>
			<td>{{ $row->nama }}</td>
			<td>{{ $row->jenis }}</td>
			<td align="center">{{ $row->before_jumlah_kecil }} {{ $row->nama_satuan_kecil }}</td>
			<td align="center">{{ $row->after_jumlah_kecil }} {{ $row->nama_satuan_kecil }}</td>
			<td align="right">{{ $row->hpp }}</td>
			<td align="right">{{ $row->harga_netto }}</td>
		</tr>
	@endforeach
	
</table>

<?php

function tglse($created) {
$time_ = explode(' ',$created);
$tgl_ = explode('-',$time_[0]);
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