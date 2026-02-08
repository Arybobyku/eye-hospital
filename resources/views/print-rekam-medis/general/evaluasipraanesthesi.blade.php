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
            <td class="table">Diagnose Medis : {{ $data->diagnosis ?? '' }}</td>
            <td class="table">Tanggal : {{ $data->tanggal ?? '' }}</td>
            <td class="table">Jam : {{ $data->jam ?? '' }}</td>
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
        <td colspan="12">Ruangan : {{ $data->ruangan ?? '' }} DIISI OLEH PASIEN</td>
    </tr>
    <tr>
        <td>Umur: {{ $data->umur ?? '' }}</td>
        <td>Jenis Kelamin</td>
        <td >L</td>
        <td><input type="checkbox" {{ $data->jenis_kelamin_pasien == 'L' ? 'checked' : '' }}></td>
        <td >P</td>
        <td><input type="checkbox" {{ $data->jenis_kelamin_pasien == 'P' ? 'checked' : '' }}></td>
        <td>Menikah</td>
        <td >Y</td>
        <td><input type="checkbox" {{ $data->menikah == 'Y' ? 'checked' : '' }}></td>
        <td >T</td>
        <td><input type="checkbox" {{ $data->menikah == 'T' ? 'checked' : '' }}></td>
        <td>Pekerjaan: {{ $data->pekerjaan ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="12" class="bold">KEBIASAAN</td>
    </tr>
    <tr>
        <td>Merokok:</td>
        <td style="width: 20px; text-align: center;">Y</td>
        <td><input type="checkbox" {{ $data->kebiasaan_merokok == 'Y' ? 'checked' : '' }}></td>
        <td style="width: 20px; text-align: center;">T</td>
        <td><input type="checkbox" {{ $data->kebiasaan_merokok == 'T' ? 'checked' : '' }}></td>
        <td>Sebanyak: {{ $data->kebiasaan_merokok_jumlah ?? '' }}</td>
        <td>Kopi/Teh/Soda:</td>
        <td style="width: 20px; text-align: center;">Y</td>
        <td><input type="checkbox" {{ $data->kebiasaan_kopi == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->kebiasaan_kopi == 'T' ? 'checked' : '' }}></td>
        <td>Sebanyak: {{ $data->kebiasaan_kopi_jumlah ?? '' }}</td>
    </tr>
    <tr>
        <td>Alkohol:</td>
        <td style="width: 20px; text-align: center;">Y</td>
        <td><input type="checkbox" {{ $data->kebiasaan_alkohol == 'Y' ? 'checked' : '' }}></td>
        <td style="width: 20px; text-align: center;">T</td>
        <td><input type="checkbox" {{ $data->kebiasaan_alkohol == 'T' ? 'checked' : '' }}></td>
        <td>Sebanyak: {{ $data->kebiasaan_alkohol_jumlah ?? '' }}</td>
        <td>Olahraga Rutin:</td>
        <td style="width: 20px; text-align: center;">Y</td>
        <td><input type="checkbox" {{ $data->kebiasaan_olahraga == 'Y' ? 'checked' : '' }}></td>
        <td style="width: 20px; text-align: center;">T</td>
        <td><input type="checkbox" {{ $data->kebiasaan_olahraga == 'T' ? 'checked' : '' }}></td>
        <td>Sebanyak: {{ $data->kebiasaan_olahraga_jumlah ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="12" class="bold">PENGOBATAN : Sebutkan dosis atau jumlah pil per hari</td>
    </tr>
    <tr>
        <td colspan="6" >Obat resep: {{ $data->obat_resep ?? '' }}</td>
        <td colspan="6" >Obat bebas (Vitamin, herbal): {{ $data->obat_bebas ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="2">Penggunaan Aspirin rutin :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->aspirin_rutin == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->aspirin_rutin == 'T' ? 'checked' : '' }}></td>
        <td colspan="6">Dosis dan frekuensi: {{ $data->aspirin_dosis ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="2">Obat Anti sakit :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->obat_anti_sakit == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->obat_anti_sakit == 'T' ? 'checked' : '' }}></td>
        <td colspan="6">Dosis dan frekuensi: {{ $data->obat_anti_sakit_dosis ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="2">Injeksi steroid tahun-tahun terakhir</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->injeksi_steroid == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->injeksi_steroid == 'T' ? 'checked' : '' }}></td>
        <td colspan="6">Tanggal dan lokasi injeksi: {{ $data->injeksi_steroid_detail ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="2">Alergi obat :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->alergi_obat == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->alergi_obat == 'T' ? 'checked' : '' }}></td>
        <td colspan="6">Daftar obat dan tipe reaksi: {{ $data->alergi_obat_detail ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="2">Alergi lateks :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->alergi_lateks == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->alergi_lateks == 'T' ? 'checked' : '' }}></td>
        <td colspan="2">alergi plaster :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->alergi_plaster == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->alergi_plaster == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td colspan="2">alergi makanan :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->alergi_makanan == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td colspan="7"><input type="checkbox" {{ $data->alergi_makanan == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="12" class="bold">RIWAYAT KELUARGA : apakah keluarga mendapat permasalahan seperti di bawah ini ?</td>
    </tr>
    <tr>
        <td >Perdarahan yang tidak normal :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_keluarga_perdarahan == 'Y' ? 'checked' : '' }}></td>
        <td >T</td>
        <td colspan="2"><input type="checkbox" {{ $data->riwayat_keluarga_perdarahan == 'T' ? 'checked' : '' }}></td>
        <td >Serangan jantung :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_keluarga_jantung == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td ><input type="checkbox" {{ $data->riwayat_keluarga_jantung == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td >Pembekuan darah tidak normal :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_keluarga_pembekuan == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td colspan="2"><input type="checkbox" {{ $data->riwayat_keluarga_pembekuan == 'T' ? 'checked' : '' }}></td>
        <td>Hipertensi :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_keluarga_hipertensi == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td ><input type="checkbox" {{ $data->riwayat_keluarga_hipertensi == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td >Permasalahan dalam pembiusan :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_keluarga_pembiusan == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td colspan="2"><input type="checkbox" {{ $data->riwayat_keluarga_pembiusan == 'T' ? 'checked' : '' }}></td>
        <td>Tuberkulosis :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_keluarga_tb == 'Y' ? 'checked' : '' }}></td>
        <td >T</td>
        <td><input type="checkbox" {{ $data->riwayat_keluarga_tb == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td >Operasi jantung koroner :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_keluarga_operasi_jantung == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td colspan="2"><input type="checkbox" {{ $data->riwayat_keluarga_operasi_jantung == 'T' ? 'checked' : '' }}></td>
        <td>Penyakit berat lainnya :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_keluarga_penyakit_berat == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td ><input type="checkbox" {{ $data->riwayat_keluarga_penyakit_berat == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td>Diabetes :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_keluarga_diabetes == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td colspan="6"><input type="checkbox" {{ $data->riwayat_keluarga_diabetes == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td colspan="12">Jelaskan penyakit keluarga apabila dijawab "Ya"</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 30px;">{{ $data->riwayat_keluarga_penjelasan ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="12">Komunikasi</td>
    </tr>
    <tr>
        <td>Bahasa</td>
        <td><input type="checkbox" {{ $data->bahasa == 'Indonesia' ? 'checked' : '' }}></td>
        <td>Indonesia</td>
        <td><input type="checkbox" {{ $data->bahasa == 'Lainnya' ? 'checked' : '' }}></td>
        <td colspan="8">Lainnya : {{ $data->bahasa_lainnya ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="3">Gangguan Penglihatan/Buta</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->gangguan_penglihatan == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td colspan="6"><input type="checkbox" {{ $data->gangguan_penglihatan == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td colspan="3">Gangguan pendengaran/Tuli</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->gangguan_pendengaran == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td colspan="6"><input type="checkbox" {{ $data->gangguan_pendengaran == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td colspan="2">Gangguan Bicara</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->gangguan_bicara == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td colspan="7"><input type="checkbox" {{ $data->gangguan_bicara == 'T' ? 'checked' : '' }}></td>
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
        <td><input type="checkbox" {{ $data->riwayat_pasien_perdarahan == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_perdarahan == 'T' ? 'checked' : '' }}></td>
        <td>Serangan jantung/Nyeri dada :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_jantung == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_jantung == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td colspan="2">Pembekuan darah tidak normal :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_pembekuan == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_pembekuan == 'T' ? 'checked' : '' }}></td>
        <td>Hepatitis/sakit kuning :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_hepatitis == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_hepatitis == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td colspan="2">Sakit maag :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_maag == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_maag == 'T' ? 'checked' : '' }}></td>
        <td>Sumbatan jalan nafas saat Tidur/sleep apnea :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_sumbatan_nafas == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_sumbatan_nafas == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td colspan="2">Anemia :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_anemia == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_anemia == 'T' ? 'checked' : '' }}></td>
        <td>Penyakit berat lainnya :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_penyakit_berat == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_penyakit_berat == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td colspan="2">Sesak Napas :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_sesak == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_sesak == 'T' ? 'checked' : '' }}></td>
        <td>Asma :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_asma == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_asma == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td colspan="2">Diabetes :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_diabetes == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_diabetes == 'T' ? 'checked' : '' }}></td>
        <td>Pingsan :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_pingsan == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->riwayat_pasien_pingsan == 'T' ? 'checked' : '' }}></td>
    </tr>   
    <tr>
        <td colspan="12">Jelaskan penyakit yang dijawab "Ya" :</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 30px;">{{ $data->riwayat_pasien_penjelasan ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 10px;"></td>
    </tr>
    <tr>
        <td >Apakah pasien pernah mendapatkan tranfusi darah?</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->transfusi_darah == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->transfusi_darah == 'T' ? 'checked' : '' }}></td>
        <td colspan="7">Bila ya, tahun berapa? {{ $data->transfusi_darah_tahun ?? '' }}</td>
    </tr>
    <tr>
        <td >Apakah pasien pernah diperiksa untuk diagnosis HIV?</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->pemeriksaan_hiv == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->pemeriksaan_hiv == 'T' ? 'checked' : '' }}></td>
        <td colspan="7">Bila ya, tahun berapa? {{ $data->pemeriksaan_hiv_tahun ?? '' }}</td>
    </tr>
    <tr>
        <td >Hasil pemeriksaan HIV :</td>
        <td>Positif</td>
        <td><input type="checkbox" {{ $data->hasil_hiv == 'Positif' ? 'checked' : '' }}></td>
        <td>Negatif</td>
        <td colspan="7"><input type="checkbox" {{ $data->hasil_hiv == 'Negatif' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td colspan="12">Apakah pasien pernah mengikuti kemoterapi atau radioterapi?</td>
    </tr>
    <tr>
        <td >Lensa kontak :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->lensa_kontak == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td colspan="3"><input type="checkbox" {{ $data->lensa_kontak == 'T' ? 'checked' : '' }}></td>
        <td>kacamata:</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->kacamata == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->kacamata == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td >alat bantu dengar :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->alat_bantu_dengar == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td colspan="3"><input type="checkbox" {{ $data->alat_bantu_dengar == 'T' ? 'checked' : '' }}></td>
        <td>Gigi Palsu:</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->gigi_palsu == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->gigi_palsu == 'T' ? 'checked' : '' }}></td>
    </tr>
    <tr>
        <td colspan="12">Riwayat operasi, tahun dan jenis operasi : {{ $data->riwayat_operasi ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="12">Riwayat operasi, tahun dan jenis operasi : {{ $data->riwayat_operasi ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="12">Jenis anestesi yang digunakan dan sebutkan komplikasi/reaksi yang dialami :</td>
    </tr>
    <tr>
        <td colspan="12" style="padding-left: 40px;">• Anestesia local :komplikasi/reaksi : {{ $data->anestesi_lokal_komplikasi ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="12" style="padding-left: 40px;">• Anestesia regional :komplikasi/reaksi : {{ $data->anestesi_regional_komplikasi ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="12" style="padding-left: 40px;">• Anestesia umum :komplikasi/reaksi : {{ $data->anestesi_umum_komplikasi ?? '' }}</td>
    </tr>
<!-- Data riwayat operasi -->
    <tr>
        <td colspan="12">
            Tanggal terakhir kali periksa kesehatan ke dokter : {{ $data->tanggal_periksa_terakhir ?? '' }} 
            dimana {{ $data->tempat_periksa_terakhir ?? '' }}
        </td>
    </tr>
    <tr>
        <td colspan="12">Untuk penyakit gangguan : {{ $data->gangguan_periksa_terakhir ?? '' }}</td>
    </tr>
    
    <!-- Khusus Pasien Perempuan -->
    <tr>
        <td colspan="12" class="bold">KHUSUS PASIEN PEREMPUAN :</td>
    </tr>
    <tr>
        <td colspan="2">Jumlah kehamilan : {{ $data->jumlah_kehamilan ?? '' }}</td>
        <td colspan="2">Jumlah anak : {{ $data->jumlah_anak ?? '' }}</td>
        <td colspan="2">Menstruasi terakhir : {{ $data->menstruasi_terakhir ?? '' }}</td>
        <td>Menyusui :</td>
        <td>Y</td>
        <td><input type="checkbox" {{ $data->menyusui == 'Y' ? 'checked' : '' }}></td>
        <td>T</td>
        <td><input type="checkbox" {{ $data->menyusui == 'T' ? 'checked' : '' }}></td>
    </tr>
</table>

<!-- PEMISAH HALAMAN: Page Break untuk halaman 2 -->
<div style="page-break-before: always;"></div>

<!-- Mulai Halaman 2 -->
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
    <td colspan="6">Nama : {{ $data->nama ?? '' }} NRM {{ $data->no_rm ?? '' }}</td>
    <td colspan="6" class="text-right">RM 4.10/EPA/22</td>
</tr>
<tr>
    <td colspan="3">Tanggal : {{ $data->tanggal ?? '' }}</td>
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
    <td>Hilangnya gigi :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_hilang_gigi == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;" colspan="3"><input type="checkbox" {{ $data->kajian_hilang_gigi == 'T' ? 'checked' : '' }}></td>

    <td>Sakit dada :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_sakit_dada == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_sakit_dada == 'T' ? 'checked' : '' }}></td>
</tr>

<tr>
    <td >Masalah mobilisasi leher :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_mobilisasi_leher == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;" colspan="3"><input type="checkbox" {{ $data->kajian_mobilisasi_leher == 'T' ? 'checked' : '' }}></td>
    <td >Denyut jantung tidak normal :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_denyut_jantung == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_denyut_jantung == 'T' ? 'checked' : '' }}></td>
</tr>
<tr>
    <td >Leher pendek :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_leher_pendek == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;" colspan="3"><input type="checkbox" {{ $data->kajian_leher_pendek == 'T' ? 'checked' : '' }}></td>
    <td>Muntah :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_muntah == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_muntah == 'T' ? 'checked' : '' }}></td>
</tr>
<tr>
    <td >Batuk :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_batuk == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;" colspan="3"><input type="checkbox" {{ $data->kajian_batuk == 'T' ? 'checked' : '' }}></td>
    <td>Susah kencing :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_susah_kencing == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_susah_kencing == 'T' ? 'checked' : '' }}></td>
</tr>
<tr>
    <td>Sesak nafas :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_sesak_nafas == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;" colspan="3"><input type="checkbox" {{ $data->kajian_sesak_nafas == 'T' ? 'checked' : '' }}></td>
    <td>Kejang :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_kejang == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_kejang == 'T' ? 'checked' : '' }}></td>
</tr>
<tr>
    <td >Baru saja menderita infeksi Saluran nafas atas:</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_infeksi_nafas == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;" colspan="3"><input type="checkbox" {{ $data->kajian_infeksi_nafas == 'T' ? 'checked' : '' }}></td>
    <td > Sedang hamil :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_hamil == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_hamil == 'T' ? 'checked' : '' }}></td>
</tr>
<tr>
    <td >Periode menstruasi tidak normal:</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_menstruasi_abnormal == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;" colspan="3"><input type="checkbox" {{ $data->kajian_menstruasi_abnormal == 'T' ? 'checked' : '' }}></td>
    <td >Pingsan :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_pingsan == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_pingsan == 'T' ? 'checked' : '' }}></td>
</tr>
<tr>
    <td >Stroke :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_stroke == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;" colspan="3"><input type="checkbox" {{ $data->kajian_stroke == 'T' ? 'checked' : '' }}></td>
    <td >Obesitas :</td>
    <td>Y</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_obesitas == 'Y' ? 'checked' : '' }}></td>
    <td>T</td>
    <td style="text-align:left;"><input type="checkbox" {{ $data->kajian_obesitas == 'T' ? 'checked' : '' }}></td>
</tr>
<tr>
    <td colspan="7">Keterangan :</td>
    <td colspan="5">{{ $data->kajian_keterangan ?? '' }}</td>
</tr>
<tr>
    <td colspan="12" style="height: 10px;"></td>
</tr>
<tr>
    <td colspan="12" class="bold">KEADAAN UMUM</td>
</tr>
<tr>
    <td colspan="12">Kesadaran : {{ $data->kesadaran ?? '' }} Visus : {{ $data->visus ?? '' }}  Faring : {{ $data->faring ?? '' }}  Gigi palsu : {{ $data->keadaan_gigi_palsu ?? '' }}</td>
</tr>
<tr>
    <td colspan="12" style="height: 10px;"></td>
</tr>
<tr>
    <td colspan="12" class="bold">PEMERIKSAAN FISIK</td>
</tr>
<tr>
    <td colspan="12">Tinggi : {{ $data->tinggi_badan ?? '' }}  Berat: {{ $data->berat_badan ?? '' }}  TD: {{ $data->tekanan_darah ?? '' }}  Nadi : {{ $data->nadi ?? '' }}  Suhu : {{ $data->suhu ?? '' }}</td>
</tr>
<tr>
    <td colspan="6">Paru-paru : {{ $data->pemeriksaan_paru ?? '' }}</td>
    <td colspan="6">Jantung : {{ $data->pemeriksaan_jantung ?? '' }}</td>
</tr>
<tr>
    <td colspan="6">Abdomen : {{ $data->pemeriksaan_abdomen ?? '' }}</td>
    <td colspan="6">Ekstremitas : {{ $data->pemeriksaan_ekstremitas ?? '' }}</td>
</tr>
<tr>
    <td colspan="6">Neurologi (bila dapat diperiksa) : {{ $data->pemeriksaan_neurologi ?? '' }}</td>
    <td colspan="6">Keterangan : {{ $data->pemeriksaan_fisik_keterangan ?? '' }}</td>
</tr>
<tr>
    <td colspan="12" style="height: 10px;"></td>
</tr>
<tr>
    <td colspan="12" class="bold">LABORATORIUM (bila tersedia)</td>
</tr>
<tr>
    <td colspan="6">Hb/Ht : {{ $data->lab_hb_ht ?? '' }}</td>
    <td colspan="6">Rontgen dada : {{ $data->lab_rontgen ?? '' }}</td>
</tr>
<tr>
    <td colspan="6">PT/APTT : {{ $data->lab_pt_aptt ?? '' }}</td>
    <td colspan="6">EKG : {{ $data->lab_ekg ?? '' }}</td>
</tr>
<tr>
    <td colspan="6">Tes kehamilan : {{ $data->lab_tes_kehamilan ?? '' }}</td>
    <td colspan="6">CO2 : {{ $data->lab_co2 ?? '' }}</td>
</tr>
<tr>
    <td colspan="6">Na/Cl : {{ $data->lab_na_cl ?? '' }}</td>
    <td colspan="6">Kalium : {{ $data->lab_kalium ?? '' }}</td>
</tr>
<tr>
    <td colspan="6">Ureum : {{ $data->lab_ureum ?? '' }}</td>
    <td colspan="6">Kreatinin : {{ $data->lab_kreatinin ?? '' }}</td>
</tr>
<tr>
    <td colspan="6">Lain-lain : {{ $data->lab_lainnya ?? '' }}</td>
    <td colspan="6">Keterangan : {{ $data->lab_keterangan ?? '' }}</td>
</tr>
<tr>
    <td colspan="12" style="height: 10px;"></td>
</tr>
<tr>
    <td colspan="12" class="bold">DIAGNOSIS : {{ $data->diagnosis ?? '' }}</td>
</tr>
<tr>
    <td colspan="12">Klasifikasi berdasarkan ASA :</td>
</tr>
<tr>
    <td colspan="12" style="padding-left: 30px;"><input type="checkbox" {{ $data->klasifikasi_asa == 'ASA 1' ? 'checked' : '' }}> 1. ASA 1 Pasien normal yang sehat</td>
</tr>
<tr>
    <td colspan="12" style="padding-left: 30px;"><input type="checkbox" {{ $data->klasifikasi_asa == 'ASA 2' ? 'checked' : '' }}> 2. ASA 2 Pasien dengan penyakit sistemik ringan</td>
</tr>
<tr>
    <td colspan="12" style="padding-left: 30px;"><input type="checkbox" {{ $data->klasifikasi_asa == 'ASA 3' ? 'checked' : '' }}> 3. ASA 3 Pasien dengan penyakit sistemik berat</td>
</tr>
<tr>
    <td colspan="12" style="padding-left: 30px;"><input type="checkbox" {{ $data->klasifikasi_asa == 'ASA 4' ? 'checked' : '' }}> 4. ASA 4 Pasien dengan penyakit sistemik berat yang mengancam nyawa</td>
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
    <td ><input type="checkbox" {{ $data->anestesi_umum_intravena ? 'checked' : '' }}></td>
    <td >Intravena</td>
    <td ><input type="checkbox" {{ $data->anestesi_umum_sungkup ? 'checked' : '' }}></td>
    <td >Sungkup Muka</td>
    <td ><input type="checkbox" {{ $data->anestesi_umum_lma ? 'checked' : '' }}></td>
    <td >Laringeal mask Airway</td>
    <td ><input type="checkbox" {{ $data->anestesi_umum_pipa ? 'checked' : '' }}></td>
    <td >Pipa Endotrakeal Tube</td>
</tr>
<tr>
    <td ><input type="checkbox"></td>
    <td colspan="3">Regional Anestesi :</td>
    <td ><input type="checkbox" {{ $data->regional_spinal ? 'checked' : '' }}></td>
    <td >Spinal Anestesi</td>
    <td ><input type="checkbox" {{ $data->regional_epidural ? 'checked' : '' }}></td>
    <td >Blok Epidural</td>
    <td ><input type="checkbox" {{ $data->regional_kombinasi ? 'checked' : '' }}></td>
    <td >Kombinasi Spinal Epidural</td>
    <td ><input type="checkbox" {{ $data->regional_peripheral ? 'checked' : '' }}></td>
    <td >Peripheral Nerve Block</td>
</tr>
<tr>
    <td><input type="checkbox" {{ $data->anestesi_umum_regional ? 'checked' : '' }}></td>
    <td colspan="11">Anestesi Umum + Regional Anestesi</td>
</tr>
<tr>
    <td colspan="6">Puasa mulai</td>
    <td colspan="6">Jam {{ $data->puasa_jam ?? '' }} Tanggal {{ $data->puasa_tanggal ?? '' }}</td>
</tr>
<tr>
    <td colspan="6">Rencana tiba di OK</td>
    <td colspan="6">Jam {{ $data->rencana_tiba_jam ?? '' }} Tanggal {{ $data->rencana_tiba_tanggal ?? '' }}</td>
</tr>
<tr>
    <td colspan="6">Rencana Operasi</td>
    <td colspan="6">Jam {{ $data->rencana_operasi_jam ?? '' }} Tanggal {{ $data->rencana_operasi_tanggal ?? '' }}</td>
</tr>
<tr>
    <td colspan="12" class="text-right">Tanda Tangan</td>
</tr>
<tr>
    <td colspan="12" class="text-right" style="height: 60px; vertical-align: bottom;">
        @if(!empty($data->ttd_dokter))
            <img src="{{ $data->ttd_dokter }}" style="max-width: 150px; max-height: 60px;">
        @endif
        <br>(Dr. {{ $data->nama_dokter_ttd ?? '' }})
    </td>
</tr>
</table>

</div>
</body>
</html>
