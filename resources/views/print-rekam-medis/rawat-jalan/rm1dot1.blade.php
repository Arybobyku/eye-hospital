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
		RM 1.1/PU(GJ)/22
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
			Rumah Sakit Khusus Mata Prima Vision Medan akan menjamin kerahasiannya.
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
			<td style="width: 35%"><b>Medan, {{ date('d')}} {{ formatBulan(date('m')) }} {{ date('Y') }} {{ date('H') }}:{{ date('i') }} WIB</b></td>
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
			<td style="width: 35%; height: 90px"></td>
			<td style="width: 30%; height: 90px">
				<img 
				src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgMzg5LjQ0NDQ1NDc2MTE5OTI3IDgyLjc3Nzc3OTk3MDY0MDA4IiB3aWR0aD0iMzg5LjQ0NDQ1NDc2MTE5OTI3IiBoZWlnaHQ9IjgyLjc3Nzc3OTk3MDY0MDA4Ij48cGF0aCBkPSJNIDExMS42ODQsMjAuODAzIEMgMTA4LjIwMiwyMC40ODEgMTA4LjM4NSwyMS4xMDcgMTA1LjA4NywyMS40MTEiIHN0cm9rZS13aWR0aD0iNS40NzQiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDEwNS4wODcsMjEuNDExIEMgMTAxLjY2OCwyMi41NzMgMTAxLjc5NCwyMi4zOTMgOTguODY3LDI0LjYyNyIgc3Ryb2tlLXdpZHRoPSI0LjIxMyIgc3Ryb2tlPSJyZ2IoMCwgMCwgMCkiIGZpbGw9Im5vbmUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCI+PC9wYXRoPjxwYXRoIGQ9Ik0gOTguODY3LDI0LjYyNyBDIDk0LjYzOCwyNy44NTggOTQuNjUyLDI3LjcxNyA5MS4wNTUsMzEuNjk3IiBzdHJva2Utd2lkdGg9IjMuNjY2IiBzdHJva2U9InJnYigwLCAwLCAwKSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L3BhdGg+PHBhdGggZD0iTSA5MS4wNTUsMzEuNjk3IEMgODYuNzg3LDM2LjAxMyA4Ni45OTcsMzYuMDQ0IDgzLjU4NSw0MC45OTgiIHN0cm9rZS13aWR0aD0iMy4zNDQiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDgzLjU4NSw0MC45OTggQyA4MS4wMTIsNDUuMzM5IDgwLjkxNSw0NS4xNTYgNzkuMzEwLDQ5Ljk4MyIgc3Ryb2tlLXdpZHRoPSIzLjQ4NCIgc3Ryb2tlPSJyZ2IoMCwgMCwgMCkiIGZpbGw9Im5vbmUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCI+PC9wYXRoPjxwYXRoIGQ9Ik0gNzkuMzEwLDQ5Ljk4MyBDIDc4LjIyMiw1My40NjUgNzguMDczLDUzLjM1NiA3Ny43MDgsNTcuMDMxIiBzdHJva2Utd2lkdGg9IjMuNzk2IiBzdHJva2U9InJnYigwLCAwLCAwKSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L3BhdGg+PHBhdGggZD0iTSA3Ny43MDgsNTcuMDMxIEMgNzUuODM0LDYxLjY0NiA3Ny4xODUsNjAuNjY4IDc3LjIzNSw2NC4zODgiIHN0cm9rZS13aWR0aD0iNC4zODEiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDc3LjIzNSw2NC4zODggQyA3OS45MzcsNjYuNjUwIDc4LjQ0OSw2Ni43NjQgODIuOTM4LDY3LjI2NiIgc3Ryb2tlLXdpZHRoPSI0Ljg4MyIgc3Ryb2tlPSJyZ2IoMCwgMCwgMCkiIGZpbGw9Im5vbmUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCI+PC9wYXRoPjxwYXRoIGQ9Ik0gODIuOTM4LDY3LjI2NiBDIDg1LjcyMiw2Ny4yMzYgODUuNTE3LDY3Ljc5NCA4OC4zOTQsNjYuNjc1IiBzdHJva2Utd2lkdGg9IjQuODQxIiBzdHJva2U9InJnYigwLCAwLCAwKSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L3BhdGg+PHBhdGggZD0iTSA4OC4zOTQsNjYuNjc1IEMgOTEuMDA5LDY1Ljk0OCA5MS4wMzIsNjYuMTIyIDkzLjU1OSw2NS4wMzkiIHN0cm9rZS13aWR0aD0iNC40MjMiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDkzLjU1OSw2NS4wMzkgQyA5Ni42MTQsNjMuOTEzIDk2LjYyMyw2My45NDcgOTkuNjIyLDYyLjY3NCIgc3Ryb2tlLXdpZHRoPSI0LjExNyIgc3Ryb2tlPSJyZ2IoMCwgMCwgMCkiIGZpbGw9Im5vbmUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCI+PC9wYXRoPjxwYXRoIGQ9Ik0gOTkuNjIyLDYyLjY3NCBDIDEwMy4wMjcsNjEuNDMzIDEwMi45NTUsNjEuMzAwIDEwNi4yNDEsNTkuODEzIiBzdHJva2Utd2lkdGg9IjMuOTQ2IiBzdHJva2U9InJnYigwLCAwLCAwKSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L3BhdGg+PHBhdGggZD0iTSAxMDYuMjQxLDU5LjgxMyBDIDEwOS43OTgsNTguMTk1IDEwOS42NzYsNTguMDgyIDExMi45MjEsNTUuOTcyIiBzdHJva2Utd2lkdGg9IjMuODkzIiBzdHJva2U9InJnYigwLCAwLCAwKSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L3BhdGg+PHBhdGggZD0iTSAxMTIuOTIxLDU1Ljk3MiBDIDExNS44NzUsNTMuODI4IDExNS44MzUsNTMuODk4IDExOC4zMTYsNTEuMjIwIiBzdHJva2Utd2lkdGg9IjMuOTM1IiBzdHJva2U9InJnYigwLCAwLCAwKSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L3BhdGg+PHBhdGggZD0iTSAxMTguMzE2LDUxLjIyMCBDIDEyMC40ODYsNDkuMzQyIDEyMC4xMTEsNDkuMzAxIDEyMS4zOTMsNDYuOTE4IiBzdHJva2Utd2lkdGg9IjQuMTM1IiBzdHJva2U9InJnYigwLCAwLCAwKSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L3BhdGg+PHBhdGggZD0iTSAxMjEuMzkzLDQ2LjkxOCBDIDEyMi42NjIsNDIuODEzIDEyMi44NDUsNDMuMDQyIDEyMy4wMzQsMzguNjIwIiBzdHJva2Utd2lkdGg9IjQuMzY5IiBzdHJva2U9InJnYigwLCAwLCAwKSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L3BhdGg+PHBhdGggZD0iTSAxMjMuMDM0LDM4LjYyMCBDIDEyMy4xOTEsMzMuNTE4IDEyMy40ODIsMzMuNTY2IDEyMy4wMzQsMjguNDI0IiBzdHJva2Utd2lkdGg9IjMuNjcxIiBzdHJva2U9InJnYigwLCAwLCAwKSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L3BhdGg+PHBhdGggZD0iTSAxMjMuMDM0LDI4LjQyNCBDIDEyMS42OTUsMTUuNzQzIDEyMi43NjQsMTkuNjY4IDEyMi4xNzksMTAuOTIwIiBzdHJva2Utd2lkdGg9IjIuOTIwIiBzdHJva2U9InJnYigwLCAwLCAwKSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L3BhdGg+PHBhdGggZD0iTSAxMjIuMTc5LDEwLjkyMCBDIDEyMy4yMzEsMTMuMzgwIDEyMi4zMjcsOS40NDggMTI0LjI5NywxNS44MzMiIHN0cm9rZS13aWR0aD0iNC4zMzIiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDEyNC4yOTcsMTUuODMzIEMgMTI1Ljg0MywxOS44NTMgMTI2LjAwNywxOS43NzEgMTI3LjczMCwyMy43MDIiIHN0cm9rZS13aWR0aD0iMy44MzkiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDEyNy43MzAsMjMuNzAyIEMgMTI4Ljg3NCwyNy4yNTYgMTI5LjI1OSwyNi44MjEgMTMxLjEyOCwyOS43NzAiIHN0cm9rZS13aWR0aD0iMy45NDUiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDEzMS4xMjgsMjkuNzcwIEMgMTMzLjk4MywzMy4zMTQgMTMzLjAyNywzMS44ODcgMTM2LjAzNywzMi45NjQiIHN0cm9rZS13aWR0aD0iNC42NzgiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDEzNi4wMzcsMzIuOTY0IEMgMTM3LjY2MCwzMC43NTcgMTM3Ljk1MywzMi42MzkgMTM5LjA2NywyOC40MjAiIHN0cm9rZS13aWR0aD0iNC43ODEiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDEzOS4wNjcsMjguNDIwIEMgMTQwLjM4MiwyMy42MzIgMTQwLjQzOSwyNi4xNDEgMTQxLjU5NywyMy43MzMiIHN0cm9rZS13aWR0aD0iNS4xNTAiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDE0MS41OTcsMjMuNzMzIEMgMTQyLjIxNCwyNi44MzIgMTQyLjg5MywyMy44NDAgMTQ0LjA4OSwyOC44MzciIHN0cm9rZS13aWR0aD0iNC44OTkiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDE0NC4wODksMjguODM3IEMgMTQ3LjAyMywzMi42ODMgMTQ2LjUzMywzMS40NTIgMTUwLjIzNCwzMi45NzMiIHN0cm9rZS13aWR0aD0iNC43MTciIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDE1MC4yMzQsMzIuOTczIEMgMTU0LjU0NywzMi4zNDQgMTUzLjMxMCwzMy4yNTEgMTU2LjY2MiwyOS45NzQiIHN0cm9rZS13aWR0aD0iNC42MzciIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDE1Ni42NjIsMjkuOTc0IEMgMTU3LjQ1NiwyNy4yNTcgMTU4LjMzNiwyOC4wOTkgMTU3LjgxMywyNC40ODQiIHN0cm9rZS13aWR0aD0iNC4zODgiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDE1Ny44MTMsMjQuNDg0IEMgMTU4LjAwOSwxOC43NjMgMTU4LjE4MSwyMS42MTkgMTU4LjExMiwxOC42OTgiIHN0cm9rZS13aWR0aD0iNC44MTkiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDE1OC4xMTIsMTguNjk4IEMgMTU3LjY0MSwyMS41NjkgMTU4LjIxMSwxOC42MzUgMTU4LjIxNiwyNC4yMjciIHN0cm9rZS13aWR0aD0iNC44MDMiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDE1OC4yMTYsMjQuMjI3IEMgMTU4LjMxNywyOC45MDYgMTU4Ljg3NiwyNy4yNzkgMTYwLjU4MiwzMC4xMTciIHN0cm9rZS13aWR0aD0iNC43NTkiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDE2MC41ODIsMzAuMTE3IEMgMTY1LjE1NiwzMS4yMjEgMTYzLjMwNiwzMS41NzMgMTY4LjE5NCwyOS41NjIiIHN0cm9rZS13aWR0aD0iNC42MjQiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDE2OC4xOTQsMjkuNTYyIEMgMTcwLjk0OSwyNi44NjcgMTcxLjEzOSwyNy45NTMgMTcyLjU0OCwyMy41ODEiIHN0cm9rZS13aWR0aD0iNC4xMDciIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDE3Mi41NDgsMjMuNTgxIEMgMTc0LjQzMiwxOS4wOTYgMTc0LjYyOCwxOS4zMDQgMTc1LjU1MSwxNC40MzYiIHN0cm9rZS13aWR0aD0iMy43ODciIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48cGF0aCBkPSJNIDE3NS41NTEsMTQuNDM2IEMgMTczLjk2NCw3LjY4MCAxNzYuNDQyLDEwLjcyNiAxNzYuNTY3LDYuODQwIiBzdHJva2Utd2lkdGg9IjMuODUwIiBzdHJva2U9InJnYigwLCAwLCAwKSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L3BhdGg+PHBhdGggZD0iTSAxNzYuNTY3LDYuODQwIEMgMTgzLjY2MSwxMC42MjIgMTgxLjMxOCw1LjMwOCAxOTAuMjYwLDkuNjkyIiBzdHJva2Utd2lkdGg9IjQuNjM5IiBzdHJva2U9InJnYigwLCAwLCAwKSIgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj48L3BhdGg+PHBhdGggZD0iTSAxOTAuMjYwLDkuNjkyIEMgMTk4LjM4NCw2LjQxOSAxOTguNTE1LDguNTI4IDIwNi4yNzYsMi42NTIiIHN0cm9rZS13aWR0aD0iMy4xNTMiIHN0cm9rZT0icmdiKDAsIDAsIDApIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiPjwvcGF0aD48L3N2Zz4="
				alt="Base64 Image"
				  style="height: 100px" width="200px">
			</td>
		</tr>
		<tr>
			<td style="width: 35%"><span style="text-decoration: underline"><b>{{ \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER').'Nama')) }}</b></span></td>
			<td style="width: 30%"><span style="text-decoration: underline"><b></b></span></td>
		</tr>
		<tr>
			<td style="width: 35%">Nama dan Tanda Tangan</td>
			<td style="width: 30%">Nama dan Tanda Tangan</td>
		</tr>
	</table>

</div>
</body>
</html>
