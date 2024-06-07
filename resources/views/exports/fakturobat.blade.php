<table border="1">
	<tr>
		<td colspan="8" align="center">REKAP PEMBAYARAN RSK MATA PRIMA VISION</td>
	</tr>
	<tr>
		<td colspan="8" align="center">Tanggal {{ tglse($dari) }}</td>
	</tr>
	<tr>
		<td>No.</td>
		<td>Vendor</td>
		<td>Tanggal/No.Invoice</td>
		<td>Jumlah</td>
		<td>Total</td>
		<td>Kepada</td>
		<td>Ket</td>
		<td>Verifikasi Staff</td>
	</tr>
	<?php $no = 1; ?>
	@foreach ($data as $row)
		<tr>
			<td>{{ $no }}</td>
			<td>{{ $row->nama_supplier }}</td>
			<td>{{ tglse($row->tanggal_faktur) }} / {{ $row->no_faktur }}</td>
			<td>{{ $row->jumlah }}</td>
			<td>{{ $row->total }}</td>
			<td></td>
			<td></td>
			<td>{{ $row->penerima }}</td>
		</tr>
		<?php $no += 1; ?>
	@endforeach
	<tr>
		<td colspan="8"></td>
	</tr>
	<tr>
		<td colspan="3" align="center">
			Diketahui Oleh
		</td>
		<td colspan="1"></td>

		<td colspan="4" align="center">
			Disetujui Oleh
		</td>
	</tr>
	<tr>
		<td colspan="3" align="center">
			Dir. PT.VIIP
		</td>
		<td colspan="1"></td>

		<td colspan="4" align="center">
			Dir.RSKM Prima Vision
		</td>
	</tr>
	<tr>
		<td colspan="3" align="center"></td>
		<td colspan="1"></td>
		<td colspan="4" align="center"></td>
	</tr>
	<tr>
		<td colspan="3" align="center"></td>
		<td colspan="1"></td>
		<td colspan="4" align="center"></td>
	</tr>
	<tr>
		<td colspan="3" align="center">
			(dr.Sujan Ali Fing, Sp.M)
		</td>
		<td colspan="1"></td>

		<td colspan="4" align="center">
			(dr.M.Faridz Syahrian, MKM, AIFO-K)
		</td>
	</tr>
</table>
<table>
	<tr>
		>
	</tr>	
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