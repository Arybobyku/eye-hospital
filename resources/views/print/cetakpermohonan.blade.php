<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Invoice</title>
    <style>
    @page { margin: 13px; }
    body { margin: 13px; }
        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }
    </style>
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;">
	{{-- <?php
		// SKP = Surat Konsul Pasien
		// $msg = 'RSKM-PV/SKP-'.date('y').'/'.date('m').'/S-';
		// $nomor = $surat->surat_ke;
		// if ($nomor > 0 && $nomor < 10) { $msg .= '000'.$nomor; }
		// else if ($nomor > 9 && $nomor < 100) { $msg .= '00'.$nomor; }
		// else if ($nomor > 99 && $nomor < 1000) { $msg .= '0'.$nomor; }
		// else if ($nomor > 999 && $nomor < 10000) { $msg .= ''.$nomor; }
		// echo $msg;
	?>	 --}}
</div>
<?php $fullpath = storage_path('app/public/header.png');  ?>
<div class="wrap">
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
						<span style="font-size: 14px; position: relative; left: -10px; top: -3px">RUMAH SAKIT KHUSUS MATA</span><br />
						<span style="font-size: 35px; position: relative; left: 10px; top: -8px; color: #18365d">PRIMA VISION</span><br />
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
	<div style="width: 100%; height: 1px; background: #353535; margin-top: -30px"></div>
	<h4 align="center" style="line-height: 0; margin-bottom:8px; font-size: 11pt">LEMBAR PEMESANAN OBAT-OBATAN/BHP ALKES</h4>
	<div style="width: 100%; height: 1px; background: #353535; margin-top: 3px"></div>
	<br />

	<table style="width: 100%; margin-top: -10px; font-size: 11pt">
		<tr>
			<td style="width: 18%">No Rencana</td>
			<td style="width: 50%">: {{ $label->no_rencana }}</td>
			<td style="width: 15%">Pegawai</td>
			<td style="width: 20%">: {{ $label->nama_pegawai }}</td>
		</tr>
		<tr>
			<td>Tanggal Rencana</td>
			<td colspan="3">: {{ tglse($label->tanggal) }}</td>
		</tr>
	</table>

	<table style="width: 100%; margin-top: 5px; font-size: 11pt" cellpadding="3" cellspacing="0" border="1">
		<thead>
			<th>No.</th>
			<th>Jenis</th>
			<th>Nama Obat</th>
			<th>Kemasan</th>
			<th>Permintaan</th>
			<th>Stok Akhir</th>
			<th>Harga Netto</th>
			<th>Total</th>
		</thead>
		<tbody>
			<?php $nomor = 1; $grandtotal = 0; ?>
			@foreach($stock as $row)
				<tr>
					<td align="center">{{ $nomor }}</td>
					<td align="center">{{ $row->jenis }}</td>
					<td>{{ $row->nama }}</td>
					<td align="center">{{ $row->hitung_kecil }} {{ $row->nama_satuan_kecil }}/{{ $row->nama_satuan_besar }}</td>
					<td align="center">{{ $row->jumlah_permohonan_kecil }}</td>
					<td align="center">{{ $row->jumlah_kecil }} {{ $row->nama_satuan_kecil }}</td>
					<td align="right">Rp. {{ number_format($row->harga_netto) }}</td>
					<?php $total = $row->harga_netto * $row->jumlah_permohonan_kecil;  ?>
					<td align="right">Rp. {{ number_format($total) }}</td>
				</tr>
				<?php $nomor += 1; $grandtotal += $total; ?>
			@endforeach
			<tr>
				<td colspan="7">Grand Total</td>
				<td align="right">Rp. {{ number_format($grandtotal) }}</td>
			</tr>
		</tbody>
	</table>

	<table style="width: 100%; margin-top: 16px; font-size: 11pt">
		<tr>
			<td style="width: 77%">&nbsp;</td>
			<td style="width: 33%" align="center">Medan, {{ tglse($label->tanggal) }}</td>
		</tr>
	</table>
	
	<table style="width: 100%; margin-top: 0px; font-size: 11pt">
		<tr>
			<td style="width: 33%" align="center">
				Diminta,<br /><br /><br /><br /><br /><br /><span style="text-decoration: underline">{{ $label->nama_pegawai }}</span>
			</td>
			<td style="width: 33%" align="center">
				Diketahui,<br /><br /><br /><br /><br /><br /><span style="text-decoration: underline">Anne Ivoni Surbakti</span>
			</td>
			<td style="width: 33%" align="center">
				Disetujui,<br /><br /><br /><br /><br /><br />
				<span style="text-decoration: underline">
					dr.M.Faridz Syahrian, MKM, AIFO-K
				</span>
			</td>
		</tr>
	</table>
	
</div>
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
function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
?>
</body>
</html>
