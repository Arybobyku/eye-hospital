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
	<br />
	<div style="width: 100%; height: 1px; background: #353535; margin-top: -47px"></div>

	<table style="width: 100%; margin-top: -26px; position: relative; top: -35px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 50%">
				<table  style="width: 100%; border: none" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border: none; padding: 3px 5px">Nama Lengkap</td>
						<td style="border: none; padding: 3px 5px">: {{ $registrasi->nama_pasien }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 3px 5px">No. Rekam Medis</td>
						<td style="border: none; padding: 3px 5px">: {{ $registrasi->rekam_medis }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 3px 5px">Nomor Registrasi</td>
						<td style="border: none; padding: 3px 5px">: {{ $registrasi->nomor }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 3px 5px">Tanggal Kunjungan</td>
						<td style="border: none; padding: 3px 5px">: 
							<?php
								$tglpemeriksaan = $pemeriksaanro->tanggal;
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
							{{ $tgl }} {{ $bln }} {{ $thn }} {{ $pemeriksaanro->waktu }}</td>
					</tr>
				</table>
			</td>
			<td style="width: 50%">
				<table style="width: 100%; border: none" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border: none; padding: 3px 5px">Dokter yang menangani</td>
						<td style="border: none; padding: 3px 5px">: {{ $registrasi->nama_dokter }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 3px 5px">Cara Masuk</td>
						<td style="border: none; padding: 3px 5px">: {{ $registrasi->cara_masuk }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 3px 5px">Cara Bayar</td>
						<td style="border: none; padding: 3px 5px">: {{ $registrasi->carabayar_nama }}</td>
					</tr>
					<tr>
						<td style="border: none; padding: 3px 5px">Status Pembayaran</td>
						<td style="border: none; padding: 3px 5px">: {{ $registrasi->status_kasir }}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table style="width: 100%; text-align: left; margin-top: -20px" cellpadding="0" cellspacing="0">
		<thead>
			<th align="center" colspan="2" style="border: 1px solid #c5c5c5; padding: 5px">RESUME MEDIS RAWAT JALAN</th>
		</thead>
		<tbody>
			<tr>
				<td align="left" valign="top" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 75px;">Annamnese</td>
				<td align="left" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 75px"></td>
			</tr>
			<tr>
				<td align="left" valign="top" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 50px;">Pemeriksaan Fisik</td>
				<td align="left" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 50px"></td>
			</tr>
			<tr>
				<td align="left" valign="top" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 35px;">Alergi Obat</td>
				<td align="left" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 35px"></td>
			</tr>
			<tr>
				<td align="left" valign="top" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 50px;">Hasil Penunjang Medis Laboratorium/Radiologi/Dll</td>
				<td align="left" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 50px"></td>
			</tr>
			<tr>
				<td align="left" valign="top" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 35px;">Diagnosa</td>
				<td align="left" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 35px"></td>
			</tr>
			<tr>
				<td align="left" valign="top" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 75px;">Terapi Tindakan</td>
				<td align="left" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 75px"></td>
			</tr>
			<tr>
				<td align="left" valign="top" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 35px;">Riwayat/Rawat Inap/Operasi/Tindakan</td>
				<td align="left" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 35px"></td>
			</tr>
			<tr>
				<td align="left" valign="top" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 35px;">Instruksi/Anjuran dan Edukasi</td>
				<td align="left" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 35px"></td>
			</tr>
			<tr>
				<td align="left" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 25px;">Kontrol pada tanggal</td>
				<td align="left" style="border: 1px solid #c5c5c5; padding: 5px; width: 40%; height: 25px">Di</td>
			</tr>
		</tbody>
		
	</table>
	<br />
	<br />
	<table style="width: 100%; text-align: center">
		<tr>
			<td>{{ date('d/m/Y') }} {{ date('H:i') }} Wib</td>
		</tr>
		<tr>
			<td>Dokter Yang Memeriksa</td>
		</tr>
		<tr>
			<td style="width: 100%; height: 60px"></td>
		</tr>
		<tr>
			<td>{{ $registrasi->nama_dokter }}</td>
		</tr>
	</table>
</div>
</body>
</html>
