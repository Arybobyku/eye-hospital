<table>
	<thead>
	<tr>
		<th>No.</th>
		<th>Jenis</th>
		<th>Nama Obat</th>
		<th>Kemasan</th>
		<th>Permintaan</th>
		<th>Stok Akhir</th>
		<th>Harga Netto</th>
		<th>Total</th>
	</tr>
	</thead>
	<tbody>
	<?php $i = 1; ?>
	@foreach($data as $row)
		<tr>
			<td>{{ $i }}</td>
			<td>{{ $row->jenis }}</td>
			<td>{{ $row->nama }}</td>
			<td>{{ $row->hitung_kecil }} {{ $row->nama_satuan_kecil }}/{{ $row->nama_satuan_besar }}</td>
			<td>{{ $row->jumlah_permohonan_kecil }}</td>
			<td>{{ $row->jumlah_kecil }} {{ $row->nama_satuan_kecil }}</td>
			<td>{{ number($row->harga_netto) }}</td>
			<?php $total = $row->harga_netto * $row->jumlah_permohonan_kecil;  ?>
			<td>{{ number($total) }}
		</tr>
		<?php $i += 1; ?>
	@endforeach
	</tbody>
</table>