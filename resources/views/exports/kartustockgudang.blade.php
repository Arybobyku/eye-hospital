<table border="1">
	<tr>
		<td colspan="9" align="center">Kartu Stock Opname Obat/Alkes Gudang</td>
	</tr>
	<tr>
		<td colspan="9" align="center">Periode {{ $dari }} Sampai Dengan {{ $ke }}</td>
	</tr>
	<tr>
		<td>No</td>
		<td>Referensi</td>
		<td>Nama Obat</td>
		<td>Dari</td>
		<td>Ke</td>
		<td>Penanggung Jawab</td>
		<td>Masuk</td>
		<td>Keluar</td>
		<td>Sisa</td>
	</tr>
@php
    $groupedData = [];
    foreach ($data as $row) {
        $groupedData[$row->nama][] = $row;
    }
@endphp

@foreach ($groupedData as $namaObat => $transactions)
    @php
        $saldo = 0;
        $counter = 1;
    @endphp
    @foreach ($transactions as $row)
        @php
            // Hitung saldo berdasarkan jenis transaksi
            if ($row->jenis_transaksi == 'masuk') {
                $saldo += $row->masuk_kecil;
            } else {
				if ($saldo == 0) {$saldo = $row->jumlah_kecil;}
                $saldo = $saldo - $row->minta_kecil;
            }
            // Simpan saldo untuk row ini
            $sisa = $saldo;
        @endphp
        <tr>
            <td>{{ $counter++ }}</td>
            <td>{{ $row->kode }}</td>
            <td>{{ $row->nama }}</td>
            <td>{{ $row->dari_nama_unit }}</td>
            <td>{{ $row->ke_nama_unit }}</td>
            <td>{{ $row->pengirim_pengguna_nama }}</td>
            <td align="right">{{ $row->jenis_transaksi == 'masuk' ? $row->masuk_kecil : '' }}</td>
            <td align="right">{{ $row->jenis_transaksi == 'keluar' ? $row->minta_kecil : '' }}</td>
            <td align="right">{{ $sisa }}</td>
        </tr>
    @endforeach
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