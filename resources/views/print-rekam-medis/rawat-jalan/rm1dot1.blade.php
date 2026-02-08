<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>RM1.1</title>
    <style>
    @page { margin: 18px; }
    body { margin: 18px; }
        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }
		
    </style>
    
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;">
</div>
<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>
<div class="wrap">
	<div style="width:100%; text-align:right; margin-bottom:5px">
		{{ $item->no_surat ?? 'RM 1.1/PU(GJ)/22' }}
	</div>
	@include('print-rekam-medis.partials.header')
	<br />

	<div style="width: 100%; text-align: center; margin-top: 14px; margin-bottom: 3px; font-weight: bold">
		PERSETUJUAN UMUM 
	</div>


	<div style="width: 100%; text-align: center; margin-top: 0px; line-height: 21px; margin-top: 20px; font-weight: bold">
		(GENERAL CONSENT)
	</div>

	{{-- <div style="width: 100%; height: 1px; background: #353535;"></div>
	<br /> --}}

	<div style="width: 100%; text-align: center; margin-top: 0px; line-height: 21px; margin-bottom: 3px; margin-top:20px; font-weight: bold">
		PASIEN/KELUARGA DAN ATAU WALI HUKUM HARUS MEMBACA, MEMAHAMI DAN MENGISI INFORMASI BERIKUT
	</div>

	<table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 100%"><b>1. PERSETUJUAN UNTUK PERAWATAN DAN PENGOBATAN</b></td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 10px; text-align: justify">&nbsp;&nbsp;&nbsp;&nbsp;Saya menyetujui untuk mendapatkan perawatan di Rumah Sakit Khusus Prima Vision Medan sebagai pasien rawat jalan/rawat inap 
			tergantung kepada kebutuhan medis. Pengobatan dapat meliputi pemeriksaan visus, tonometri dan prosedur rutin seperti cairan infuse atau suntikan 
		dan evaluasi (wawancara dan pemeriksaan fisik).</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
				&nbsp;&nbsp;&nbsp;&nbsp;Persetujuan yang saya berikan tidak termasuk persetujuan untuk prosedur/tindakan invasif (misalnya operasi) atau tindakan yang mempunyai resiko tingi.
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
				&nbsp;&nbsp;&nbsp;&nbsp;Jika saya memutuskan untuk menghentikan perawatan medis untuk diri saya, saya memahami dan menyadari bahwa Rumah Sakit Khusus Mata Prima Vision ataupun dokter tidak 
			bertanggung jawab atau hasil yang merugikan saya.
			</td>
		</tr>
<tr>
			<td style="width: 100%; padding-top: 15px">
			<b>2. PERSETUJUAN PELEPASAN INFORMASI</b>
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 10px; text-align: justify">&nbsp;&nbsp;&nbsp;&nbsp;Saya memahami informasi yang ada di dalam Saya, termasuk diagnosis, hasil laboratorium dan hasil tes diagnostic yang digunakan untuk perawatan medis, 
			Rumah Sakit Khusus Mata Prima Vision Medan akan menjamin kerahasiaannya.
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
				&nbsp;&nbsp;&nbsp;&nbsp;Saya memberi wewenang kepada Rumah Sakit Khusus Mata Prima Vision Medan untuk memberikan informasi tentang diagnosis, hasil pelayanan dan pengobatan bila diperlukan untuk memproses 
			klaim asuransi/perusahaan atau lembaga pemerintah.
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
				&nbsp;&nbsp;&nbsp;&nbsp;Saya memberi wewenang kepada Rumah Sakit Khusus Mata Prima Vision Medan untuk memberikan informasi tentang diagnosis, hasil pelayanan dan pengobatan saya kepada anggota keluarga saya 
			dan kepada :
			</td>
		</tr>
		<tr>
			<td style="width: 100%; padding-left: 20px; padding-top: 5px">
				a. {{ $item->info_kepada_a ?? '____________________' }}
			</td>
		</tr>
		<tr>
			<td style="width: 100%; padding-left: 20px; padding-top: 3px">
				b. {{ $item->info_kepada_b ?? '____________________' }}
			</td>
		</tr>
		<tr>
			<td style="width: 100%; padding-left: 20px; padding-top: 3px">
				c. {{ $item->info_kepada_c ?? '____________________' }}
			</td>
		</tr>
		<tr>
			<td style="width: 100%; padding-top: 15px">
			<b>3. HAK DAN TANGGUNG JAWAB PASIEN</b>
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 10px; text-align: justify">&nbsp;&nbsp;&nbsp;&nbsp;Saya memiliki hak untuk mengambil bagian dalam keputusan mengenai penyakit saya dalam hal perawatan medis dan rencana pengobatan. Saya telah 
			mendapat informasi tentang Hak dan tanggung Jawab Pasien Rumah Sakit Khusus Mata Prima Vision Medan melalui leaflet dan banner yang disediakan petugas.
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
				&nbsp;&nbsp;&nbsp;&nbsp;Saya memahami bahwa Rumah Sakit Khusus Mata Prima Vision Medan tidak bertanggung jawab atas kehilangan barang-barang pribadi dan barang yang 
			dibawa ke Rumah Sakit Khusus Mata Prima Vision Medan
			</td>
		</tr>

		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
				&nbsp;&nbsp;&nbsp;&nbsp;Saya memahami bahwa Rumah Sakit Khusus Mata Prima Vision Medan tidak memperbolehkan pendokumentasian semua tindakan yang dilakukan di Rumah Sakit Khusus Mata Prima Vision, 
			baik berbentuk Foto/Video/Audio (Sesuai UU Praktik Kedokteran No. 29/2004 Pasal 48 dan 51, UU Telekomunikasi No. 36/1999).
			</td>
		</tr>
		<tr>
			<td style="width: 100%; padding-top: 15px">
			<b>4. INFORMASI RAWAT INAP</b>
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 10px; text-align: justify">&nbsp;&nbsp;&nbsp;&nbsp;Saya telah menerima informasi tentang peraturan yang telah diberlakukan oleh Rumah Sakit Khusus Mata Prima Vision Medan dan saya beserta keluarga 
			bersedia untuk mematuhinya, termasuk mematuhi berkunjung pasien sesuai dengan aturan di Rumah Sakit Khusu Mata Prima Vision Medan.
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
				&nbsp;&nbsp;&nbsp;&nbsp;Anggota keluarga saya yang menunggu saya bersedia untuk selalu memakai tanda pengenal khusus yang diberikan Rumah Sakit Khusus Mata Prima Vision Medan, dan 
			demi keamanan seluruh pasien setiap keluarga dan siapapun yang akan mengunjungi saya diluar jam berkunjung bersedia untuk diminta/diperiksa identitasnya dan 
			memakai identitas yang diberikan Rumah Sakit Khusus Mata Prima Vision Medan.
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
				&nbsp;&nbsp;&nbsp;&nbsp;Saya memahami bahwa saya dapat memilih turun kelas perawatan apabila kamar perawatan yang menjadi hak saya sesuai fasilitas kartu BPJS saya tidak akan tersedia. Dan saya 
			telah memahami apa yang menjadi kewajiban dan hak saya memilih hal tersebut. Dan saya bersedia mengikuti peraturan Rumah Sakit Khusus Mata Prima Vision Medan yang berlaku saat ini.
			</td>
		</tr>

		<tr>
			<td style="width: 100%; padding-top: 15px">
			<b>5. BIAYA PERAWATAN</b>
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 10px; text-align: justify">&nbsp;&nbsp;&nbsp;&nbsp;Saya menyatakan setuju sebagai pasien/penanggung jawab dengan status umum untuk membayar total biaya perawatan yang diberikan sesuai rincian biaya dan ketentuan Rumah Sakit Khusus Mata Prima Vision Medan.
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
			Saya menyatakan setuju sebagai pasien/penanggung jawab pasien dengan biaya ditanggung penjamin untuk segera melengkapi berkas persyaratan administrasi paling lambat 3x24 jam.
			</td>
		</tr>
		<tr>
			<td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
			Saya telah membaca isi dari pernyataan ini/telah dibacakan isi dari pernyataan ini, dan saya telah memahami isi dari pernyataan ini. Dan semua pernyataan saya telah dijawab dengan jelas.
			</td>
		</tr>
	</table>

<table style="width: 100%; margin-top: 50px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="width: 35%">
				<b>Medan, 
				@if($item->tanggal)
				    @php
				        $dt = \Carbon\Carbon::parse($item->tanggal);
				    @endphp
				    {{ $dt->format('d') }}
				    {{ formatBulan($dt->format('m')) }}
				    {{ $dt->format('Y') }}
				@endif
				@if($item->waktu)
				    {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}
				@endif
				WIB</b>
			</td>
			<td rowspan="6" style="width: 35%"></td>
			<td style="width: 30%"></td>
		</tr>
		<tr>
			<td style="width: 35%; padding-top: 3px">Pemberi Informasi dari</td>
			<td style="width: 30%; padding-top: 3px">Penerima Informasi</td>
		</tr>
		<tr>
			<td style="width: 35%; padding-top: 3px">RS Khusus Mata Prima Vision</td>
			<td style="width: 30%; padding-top: 3px">(Pasien/Keluarga Pasien)</td>
		</tr>
		<tr>
			<td style="width: 35%; height: 90px">
				    <img src="{{ $item->ttd_dokter }}" alt="Base64 Image" width="100px"> <br>
			</td>
			<td style="width: 30%; height: 90px">
				    <img src="{{ $item->ttd_keluarga }}" alt="Base64 Image" width="100px"> <br>
			</td>
		</tr>
		<tr>
			<td style="width: 35%">({{ $item->nama_dokter_ttd }})</td>
			<td style="width: 30%">({{ $item->nama_keluarga_ttd }})</td>
		</tr>
	</table>
</div>
</body>
</html>
