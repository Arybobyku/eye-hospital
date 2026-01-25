<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>REKAM MEDIS GENERAL - EVALUASI PRA ANESTHESI</title>
    <style>
    @page { 
        margin: 18px;
        size: A4;
    }
    
    body { 
        margin: 18px; 
        font-family: Arial, sans-serif;
        font-size: 10px;
        line-height: 1.5;
        color: #000;
    }
    
    .wrap {
        width: 100%;
        height: auto;
        display: inline-block;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        page-break-inside: auto;
    }
    
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    
    td {
        padding: 4px 6px;
        vertical-align: middle;
    }
    
    .text-center {
        text-align: center;
    }
    
    .text-right {
        text-align: right;
    }
    
    .bold {
        font-weight: bold;
        padding: 6px !important;
        background-color: #f5f5f5;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }
    
    input[type="checkbox"] {
        width: 14px;
        height: 14px;
        margin: 0;
        vertical-align: middle;
        cursor: pointer;
    }
    
    .table {
        border-right: 1px solid black;
        padding-left: 5px;
        width: 100%;
    }
    
    /* Style untuk cell yang hanya berisi checkbox */
    td:has(> input[type="checkbox"]:only-child) {
        text-align: center;
        padding: 4px 3px;
        width: 25px;
    }
    
    /* Section headers dengan visual hierarchy */
    td.bold {
        letter-spacing: 0.3px;
    }
    
    /* Spacing untuk baris kosong */
    td[style*="height: 10px"] {
        padding: 0;
        height: 10px;
    }
    
    td[style*="height: 30px"] {
        padding: 0;
        height: 30px;
    }
    
    td[style*="height: 40px"],
    td[style*="height: 60px"] {
        padding: 0;
    }
    
    /* Optimasi untuk kolom Y/T/L/P */
    colgroup col:nth-child(3),
    colgroup col:nth-child(5),
    colgroup col:nth-child(8),
    colgroup col:nth-child(10) {
        width: 18px !important;
    }
    
    colgroup col:nth-child(4),
    colgroup col:nth-child(6),
    colgroup col:nth-child(9),
    colgroup col:nth-child(11) {
        width: 25px !important;
    }
    
    /* Style untuk cell yang hanya berisi Y, T, L, atau P */
    td {
        min-width: auto;
    }
    
    /* Cell yang berisi single character Y/T/L/P */
    td:is(:has(> :only-child:is(:not(input)))) {
        text-align: center;
        width: 18px;
        max-width: 18px;
        padding: 4px 2px;
    }
    
    
    </style>
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;">
</div>
<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  
<div class="wrap">
	<div style="width:100%; text-align:right; margin-bottom:5px">
		RM 4.10/EPA/22
	</div>
	@include('print-rekam-medis.partials.header')
    <table style="width: 100%;  border: 1px solid black;" cellpadding="0" cellspacing="0" >
        <tr>
            <td colspan="3" style="font-weight: bold; text-align: center; padding: 7px; border-bottom: 1px solid black;">
            EVALUASI PRA ANESTHESI
            </td>
        </tr>
        <tr>
            <td class="table">Diagnose Medis :</td>
            <td class="table">Tanggal :</td>
            <td class="table">Jam :</td>
        </tr>
    </table>

<table style="border-collapse: collapse;">
    <colgroup>
        <col style="width: 15%;">
        <col style="width: 12%;">
        <col style="width: 2%;">
        <col style="width: 2%;">
        <col style="width: 2%;">
        <col style="width: 2%;">
        <col style="width: 15%;">
        <col style="width: 2%;">
        <col style="width: 2%;">
        <col style="width: 2%;">
        <col style="width: 2%;">
        <col style="width: auto;">
    </colgroup>
    
    <tr>
        <td colspan="12">Ruangan : DIISI OLEH PASIEN</td>
    </tr>
    <tr>
        <td>Umur:</td>
        <td>Jenis Kelamin</td>
        <td >L</td>
        <td><input type="checkbox"></td>
        <td >P</td>
        <td><input type="checkbox"></td>
        <td>Menikah</td>
        <td >Y</td>
        <td><input type="checkbox"></td>
        <td >T</td>
        <td><input type="checkbox"></td>
        <td>Pekerjaan:</td>
    </tr>
    <tr>
        <td colspan="12" class="bold">KEBIASAAN</td>
    </tr>
    <tr>
        <td>Merokok:</td>
        <td style="width: 20px; text-align: center;">Y</td>
        <td><input type="checkbox"></td>
        <td style="width: 20px; text-align: center;">T</td>
        <td><input type="checkbox"></td>
        <td>Sebanyak:</td>
        <td>Kopi/Teh/Soda:</td>
        <td style="width: 20px; text-align: center;">Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td>Sebanyak:</td>
    </tr>
    <tr>
        <td>Alkohol:</td>
        <td style="width: 20px; text-align: center;">Y</td>
        <td><input type="checkbox"></td>
        <td style="width: 20px; text-align: center;">T</td>
        <td><input type="checkbox"></td>
        <td>Sebanyak:</td>
        <td>Olahraga Rutin:</td>
        <td style="width: 20px; text-align: center;">Y</td>
        <td><input type="checkbox"></td>
        <td style="width: 20px; text-align: center;">T</td>
        <td><input type="checkbox"></td>
        <td>Sebanyak:</td>
    </tr>
    <tr>
        <td colspan="12" class="bold">PENGOBATAN : Sebutkan dosis atau jumlah pil per hari</td>
    </tr>
    <tr>
        <td colspan="6" >Obat resep:</td>
        <td colspan="6" >Obat bebas (Vitamin, herbal):</td>
    </tr>
    <tr>
        <td colspan="2">Penggunaan Aspirin rutin :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td colspan="6">Dosis dan frekuensi:</td>
    </tr>
    <tr>
        <td colspan="2">Obat Anti sakit :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td colspan="6">Dosis dan frekuensi:</td>
    </tr>
    <tr>
        <td colspan="2">Injeksi steroid tahun-tahun terakhir</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td colspan="6">Tanggal dan lokasi injeksi:</td>
    </tr>
    <tr>
        <td colspan="2">Alergi obat :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td colspan="6">Daftar obat dan tipe reaksi:</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="2">Alergi lateks :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td colspan="2">alergi plaster :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
    </tr>
    <tr>
        <td colspan="2">alergi makanan :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td colspan="7"><input type="checkbox"></td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr><tr>
    <td colspan="12" class="bold">RIWAYAT KELUARGA : apakah keluarga mendapat permasalahan seperti di bawah ini ?</td>
</tr>
<tr>
    <td >Perdarahan yang tidak normal :</td>
    <td>Y</td>
    <td><input type="checkbox"></td>
    <td >T</td>
    <td colspan="2"><input type="checkbox"></td>
    <td >Serangan jantung :</td>
    <td>Y</td>
    <td><input type="checkbox"></td>
    <td>T</td>
    <td ><input type="checkbox"></td>
</tr>
<tr>
    <td >Pembekuan darah tidak normal :</td>
    <td>Y</td>
    <td><input type="checkbox"></td>
    <td>T</td>
    <td colspan="2"><input type="checkbox"></td>
    <td>Hipertensi :</td>
    <td>Y</td>
    <td><input type="checkbox"></td>
    <td>T</td>
    <td ><input type="checkbox"></td>
</tr>
<tr>
    <td >Pemersalahan dalam pembuluh darah :</td>
    <td>Y</td>
    <td><input type="checkbox"></td>
    <td>T</td>
    <td colspan="2"><input type="checkbox"></td>
    <td>Tuberkulosis :</td>
    <td>Y</td>
    <td><input type="checkbox"></td>
    <td >T</td>
    <td><input type="checkbox"></td>
</tr>
<tr>
    <td ></td>Operasi jantung koroner :</td>
    <td>Y</td>
    <td><input type="checkbox"></td>
    <td>T</td>
    <td colspan="2"><input type="checkbox"></td>
    <td>Penyakit berat lainnya :</td>
    <td>Y</td>
    <td><input type="checkbox"></td>
    <td>T</td>
    <td ><input type="checkbox"></td>
</tr>
<tr>
    <td>Diabetes :</td>
    <td>Y</td>
    <td><input type="checkbox"></td>
    <td>T</td>
    <td colspan="6"><input type="checkbox"></td>
</tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="12">Jelaskan penyakit keluarga apabila dijawab "Ya"</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 30px;"></td>
    </tr>
    <tr>
        <td colspan="12">Komunikasi</td>
    </tr>
    <tr>
        <td>Bahasa</td>
        <td><input type="checkbox"></td>
        <td>Indonesia</td>
        <td><input type="checkbox"></td>
        <td colspan="8">Lainnya : ……………………………</td>
    </tr>
    <tr>
        <td colspan="3">Gangguan Penglihatan/Buta</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td colspan="6"><input type="checkbox"></td>
    </tr>
    <tr>
        <td colspan="3">Gangguan penglihatan/Tuli</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td colspan="6"><input type="checkbox"></td>
    </tr>
    <tr>
        <td colspan="2">Gangguan Bicara</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td colspan="7"><input type="checkbox"></td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="12" class="bold">RIWAYAT PENYAKIT PASIEN : apakah pasien pernah menderita penyakit di bawah ini?</td>
    </tr>
    <tr>
        <td colspan="2">Perdarahan yang tidak normal :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td>Serangan jantung/Nyeri dada :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
    </tr>
        <tr>
        <td colspan="2">Pembekuan darah tidak normal :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td>Hepatitis/sakit kuning :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
    </tr>
    </tr>
        <tr>
        <td colspan="2">Sakit maag :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td>Sumbatan jalan nafas saat Tidur/sleep apnea :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
    </tr>
    </tr>
        <tr>
        <td colspan="2">Stroke :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td>Penyakit berat lainnya :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
    </tr>
    </tr>
        <tr>
        <td colspan="2">Sesak Napas :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td>Asma :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
    </tr>
    </tr>
        <tr>
        <td colspan="2">Diabetes :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td>Pingsan :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
    </tr>   
    <tr>
        <td colspan="12">Jelaskan penyakit yang dijawab "Ya" :</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 30px;"></td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td >Apakah pasien pernah mendapatkan tranfusi darah?</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td colspan="7">Bila ya, tahun berapa?</td>
    </tr>
    <tr>
        <td >Apakah pasien pernah diperiksa untuk diagnosis HUV?</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
        <td colspan="7">Bila ya, tahun berapa?</td>
    </tr>
    <tr>
        <td >Hasil pemeriksaan HIV :</td>
        <td>Positif</td>
        <td><input type="checkbox"></td>
        <td>Negatif</td>
        <td colspan="7"><input type="checkbox"></td>
    </tr>
    <tr>
        <td colspan="12">Apakah pasien pernah mengikuti kemoterapi atau radioterapi?</td>
    </tr>
    <tr>
        <td >Lensa kontak :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td colspan="3"><input type="checkbox"></td>
        <td>kacamata:</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
    </tr>
        <tr>
        <td >alat bantu dengar :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td colspan="3"><input type="checkbox"></td>
        <td>Gigi Palsu:</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td><input type="checkbox"></td>
    </tr>
    <tr>
        <td colspan="12">Riwayat operasi, tahun dan jenis operasi :</td>
    </tr>
    <tr>
        <td colspan="12">Jenis anestesi yang digunakan dan sebutkan komplikasi/reaksi yang dialami :</td>
    </tr>
    <tr>
        <td colspan="12" style="padding-left: 40px;">• Anestesia local :komplikasi/reaksi :</td>
    </tr>
    <tr>
        <td colspan="12" style="padding-left: 40px;">• Anestesia regional :komplikasi/reaksi :</td>
    </tr>
    <tr>
        <td colspan="12" style="padding-left: 40px;">• Anestesia umum :komplikasi/reaksi :</td>
    </tr>
    <tr>
        <td colspan="12">Tanggal terakhir kali periksa kesehatan ke dokter : _____________ dimana _____________</td>
    </tr>
    <tr>
        <td colspan="12">Untuk penyakit gangguan : _____________</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="12" class="bold">KHUSUS PASIEN PEREMPUAN :</td>
    </tr>
    <tr>
        <td colspan="2">Jumlah kehamilan : __________</td>
        <td colspan="2">Jumlah anak : __________</td>
        <td colspan="2">Menstruasi terakhir : ________</td>
        <td>Menyusui :</td>
        <td>Y</td>
        <td><input type="checkbox"></td>
        <td>T</td>
        <td ><input type="checkbox"></td>
    </tr>
</table>

<!-- Page 2 -->
<div style="page-break-before: always;"></div>

<table style="border-collapse: collapse;">
    <colgroup>
        <col style="width: 8%;">
        <col style="width: 10%;">
        <col style="width: 2%;">
        <col style="width: 2%;">
        <col style="width: 2%;">
        <col style="width: 2%;">
        <col style="width: 8%;">
        <col style="width: 2%;">
        <col style="width: 2%;">
        <col style="width: 2%;">
        <col style="width: 2%;">
        <col style="width: auto;">
    </colgroup>
    
    <tr>
        <td colspan="6">Nama : ___________________ NRM</td>
        <td colspan="6" class="text-right">RM 4.10/EPA/22</td>
    </tr>
    <tr>
        <td colspan="3">Tanggal : ___________________</td>
        <td colspan="9"></td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="12" class="bold">DIISI OLEH DOKTER</td>
    </tr>
    <tr>
        <td colspan="12" class="bold">KAJIAN SISTEM</td>
    </tr>
    <tr>
        <td>Hilangenya gigi :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;" colspan="3"><input type="checkbox"></td>

        <td>Sakit dada :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;"><input type="checkbox"></td>
    </tr>

    <tr>
        <td >Masalah mobilisasi lider :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;" colspan="3"><input type="checkbox"></td>
        <td >Denyut jantung tidak normal :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;"><input type="checkbox"></td>
    </tr>
    <tr>
        <td >Lebar perotok :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;" colspan="3"><input type="checkbox"></td>
        <td>Muntah :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;"><input type="checkbox"></td>
    </tr>
    <tr>
        <td >Sakit tenggorakan :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;" colspan="3"><input type="checkbox"></td>
        <td>Perut pusing :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;"><input type="checkbox"></td>
    </tr>
    <tr>
        <td>Sesak nafas :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;" colspan="3"><input type="checkbox"></td>
        <td>Kejang :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;"><input type="checkbox"></td>
    </tr>
    <tr>
        <td >Baru saja menderita infeksi</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;" colspan="3"><input type="checkbox"></td>
        <td > Sedang hamil :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;"><input type="checkbox"></td>
    </tr>
    <tr>
        <td >Saluran nafas atas :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;" colspan="3"><input type="checkbox"></td>
        <td >Pingsan :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;"><input type="checkbox"></td>
    </tr>
    <tr>
        <td >Periode menstruasi tidak normal</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;" colspan="3"><input type="checkbox"></td>
        <td >Obesitas :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;"><input type="checkbox"></td>
    </tr>
    <tr>
        <td>stroke :</td>
        <td>Y</td>
        <td style="text-align:left;"><input type="checkbox"></td>
        <td>T</td>
        <td style="text-align:left;" colspan="3"><input type="checkbox"></td>
        <td colspan="5">Keterangan :</td>
    </tr>
    <tr>
        <td colspan="12">Periode tidak stabil :</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="12" class="bold">KEADAAN UMUM</td>
    </tr>
    <tr>
        <td colspan="12">Kesadaran : ______ Visue : ______  Faring : ________  Gigi palsu : _________</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="12" class="bold">PERIKSAAN FISIK</td>
    </tr>
    <tr>
        <td colspan="12">Tinggi : ______  Berat: ______  TD: ______  Nadi : ______  Suhu : ________</td>
    </tr>
    <tr>
        <td colspan="6">Paru-paru :</td>
        <td colspan="6">Jantung :</td>
    </tr>
    <tr>
        <td colspan="6">Abdomen :</td>
        <td colspan="6">Ekstirmitas :</td>
    </tr>
    <tr>
        <td colspan="6">Neurologi (bila dapat diperiksa)</td>
        <td colspan="6">Keterangan :</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="12" class="bold">LABORATORIUM (bila tersedia)</td>
    </tr>
    <tr>
        <td colspan="6">Hb/Ht : ___________________</td>
        <td colspan="6">Rontgen dada : ___________________</td>
    </tr>
    <tr>
        <td colspan="6">PT/APTT : ___________________</td>
        <td colspan="6">EKG : ___________________</td>
    </tr>
    <tr>
        <td colspan="6">Tes kehamilan : ___________________</td>
        <td colspan="6">Co2 : ___________________</td>
    </tr>
    <tr>
        <td colspan="6">Kalium : ___________________</td>
        <td colspan="6">Kreatinin : ___________________</td>
    </tr>
    <tr>
        <td colspan="6">Uream : ___________________</td>
        <td colspan="6">Glukosa : ___________________<</td>
    </tr>
    <tr>
        <td colspan="6">Lain-lain : ___________________</td>
        <td colspan="6">Keterangan : ___________________</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="12" class="bold">DIAGNOSIS :</td>
    </tr>
    <tr>
        <td colspan="12">Klasifikasi berdasarkan ASA :</td>
    </tr>
    <tr>
        <td colspan="12" style="padding-left: 30px;">1. ASA 1 Pasien normal yang sehat</td>
    </tr>
    <tr>
        <td colspan="12" style="padding-left: 30px;">2. ASA 2 Pasien dengan penyakit sistemik ringan</td>
    </tr>
    <tr>
        <td colspan="12" style="padding-left: 30px;">3. ASA 3 Pasien dengan penyakit sistemik berat</td>
    </tr>
    <tr>
        <td colspan="12" style="padding-left: 30px;">4. ASA 4 Pasien dengan penyakit sistemik berat yang mengancam nyawa</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="12" class="bold">REKOMENDASI TINDAKAN ANESTESI YANG DIPILIH :</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td ><input type="checkbox"></td>
        <td  colspan="3">Anestesi Umum :</td>
        <td ><input type="checkbox"></td>
        <td >Intevena</td>
        <td ><input type="checkbox"></td>
        <td >Sungkup Muka</td>
        <td ><input type="checkbox"></td>
        <td >Laringeal mask Airway</td>
        <td ><input type="checkbox"></td>
        <td >Pipa Endotrakeal Tube</td>
    </tr>
    <tr>
        <td ><input type="checkbox"></td>
        <td colspan="3">Regional Anestesi :</td>
        <td ><input type="checkbox"></td>
        <td >Spinal Anestesi Blok</td>
        <td ><input type="checkbox"></td>
        <td >Epidural</td>
        <td ><input type="checkbox"></td>
        <td >Combinasi Spinal Epidural</td>
        <td ><input type="checkbox"></td>
        <td >Peripheral Nerve Block</td>
    </tr>
    <tr>
        <td><input type="checkbox"></td>
        <td colspan="11">Anestesi Umum + Regional Anestesi</td>
    </tr>
    <tr>
        <td colspan="6">Puasa mulai</td>
        <td colspan="6">Jam _______ Tanggal _______</td>
    </tr>
    <tr>
        <td colspan="6">Rencana elasi di OK</td>
        <td colspan="6">Jam _______ Tanggal _______</td>
    </tr>
    <tr>
        <td colspan="6">Rencana Operasi</td>
        <td colspan="6">Jam _______ Tanggal _______</td>
    </tr>
    <tr>
        <td colspan="12" class="text-right">Tanda Tangan</td>
    </tr>
    <tr>
        <td colspan="12" class="text-right" style="height: 60px; vertical-align: bottom;">(Dr. _______________)</td>
    </tr>
</table>

</div>
</body>
</html>
