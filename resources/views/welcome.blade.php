<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="nametitle" content="{{ Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username')) }}">
<meta name="usernametitle" content="{{ Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Sebagai')) }}">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}" type="text/css">
<title>-</title>
</head>

<body>
	<?php 
	// if(\Storage::exists('public/sliderfile/2bd886e7-4104-4340-b0fc-fe88c3b71403_files.jpg')){
	// 	dd('ada');
	// }
	// $text = '[{"obat_uuid":"95879247-4d95-4679-8ae6-555b7b8cb28c","nama":"Zophtal Eye Drops","kategori":"-","formularium":"-","golongan":"-","jenis":"Obat","satuan_uuid_besar":"-","nama_satuan_besar":"Botol","satuan_uuid_kecil":"-","nama_satuan_kecil":"Botol","hitung_besar":"1","hitung_kecil":"1","harga_netto":205000,"harga_netto_discount":0,"harga_netto_ppn":11,"hpp":227550,"margin_resep":"20","margin_non_resep":"20","hja_resep":273060,"hja_non_resep":273060,"hja_resep_besar":273060,"hja_non_resep_besar":273060,"jumlah_kecil":1,"jumlah_besar":1,"komposisi":"","satuan_komposisi_uuid":"","nama_satuan_komposisi":"Silahkan Pilih","dosis_diperlukan":"","satuan_diperlukan":"","satuan_diperlukan_uuid":"","nama_satuan_diperlukan":"Silahkan Pilih","total":273060}]';
	// $informasi = json_decode($text);
	// foreach($informasi as $rowin) {
	// 	echo $rowin->obat_uuid;
	// 			}
	//
		// $alphabetRange = range('A', 'Z');
		// $alphabet = $alphabetRange[18];
		// $cellRange      = 'A1:'.$alphabet.'30';
		// echo $cellRange;
		// $nomor_i = 1;
		// $a = 'RM/RSKMPV/8875/'.date('Ymd').'00010';
		// $potong_kalimat = substr($a, -5);
		// $potong_kalimat = (int) $potong_kalimat;
		// $nomor_i += $potong_kalimat;
		// echo $nomor_i;
	?>
	<div id="app">
		<data-component></data-component>
	</div>
	@vite('resources/js/app.js')
</body>

</html>
