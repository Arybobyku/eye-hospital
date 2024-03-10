<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;

class MigrasiCtrl extends Controller
{

	public function setupuuidstockopname(Request $request) {
		date_default_timezone_set("Asia/Jakarta");
		set_time_limit(2400);
		$arr = array();
		$obat = DB::table('obat')
			->orderBy('id', 'asc')
			->chunk(25, function ($obat) use ($arr) {
				foreach ($obat as $value) {
					$arry = array('obat_uuid' => $value->uuid);
					$updated = DB::table('stock_opname')->where('nama', '=', $value->nama)->update($arry);
				}
			});
		return "Setup Uuid Stock Opname => Alhamdulillahirabbil'aalamiin";;
	}

	public function converttosmalltext(Request $request)
  {

		date_default_timezone_set("Asia/Jakarta");
		set_time_limit(2400);
		$arr = array();
		$listpaketdata = DB::table('list_paket_bedah')
			->orderBy('id', 'asc')
			->chunk(25, function ($listpaketdata) use ($arr) {
				foreach ($listpaketdata as $value) {
					$arry = array(
						'label' => $value->label  != '-' && $value->label ? ucwords(strtolower($value->label)) : '-',
						'nama' => $value->nama  != '-' && $value->nama ? ucwords(strtolower($value->nama)) : '-'
					);
					$updated = DB::table('list_paket_bedah')->where('id', '=', $value->id)->update($arry);
				}
			});
		return "Konvert to small text => Alhamdulillahirabbil'aalamiin";
	}

  public function pasien(Request $request)
  {
		date_default_timezone_set("Asia/Jakarta");
		set_time_limit(2400);
		$arr = array();
    $pasien_m = DB::connection('pgsql_second')
			->table('pasien_m')
			->leftJoin('propinsi_m', 'pasien_m.propinsi_id', '=', 'propinsi_m.propinsi_id')
			->leftJoin('kabupaten_m', 'pasien_m.kabupaten_id', '=', 'kabupaten_m.kabupaten_id')
			->leftJoin('kecamatan_m', 'pasien_m.kecamatan_id', '=', 'kecamatan_m.kecamatan_id')
			->leftJoin('kelurahan_m', 'pasien_m.kelurahan_id', '=', 'kelurahan_m.kelurahan_id')
			->leftJoin('kelompokumur_m', 'pasien_m.kelompokumur_id', '=', 'kelompokumur_m.kelompokumur_id')
			->select([
				'pasien_m.pasien_id as pasien_id',
				'pasien_m.namadepan as nama_depan',
				'pasien_m.nama_pasien as nama_pasien',
				'pasien_m.tempat_lahir as tempat_lahir',
				'pasien_m.jenisidentitas as jenisidentitas',
				'pasien_m.no_identitas_pasien as no_identitas_pasien',
				'pasien_m.jeniskelamin as jeniskelamin',
				'pasien_m.alamat_pasien as alamat_pasien',
				'pasien_m.no_mobile_pasien as no_mobile_pasien',
				'pasien_m.agama as agama',
				'pasien_m.statusperkawinan as statusperkawinan',
				'pasien_m.golongandarah as golongandarah',
				'pasien_m.no_rekam_medik as no_rekam_medik',
				'pasien_m.tanggal_lahir as tanggal_lahir',
				'propinsi_m.propinsi_nama as propinsi_nama',
				'kabupaten_m.kabupaten_nama as kabupaten_nama',
				'kecamatan_m.kecamatan_nama as kecamatan_nama',
				'kelurahan_m.kelurahan_nama as kelurahan_nama',
				'kelompokumur_m.kelompokumur_id as kelompokumur_id',
				'kelompokumur_m.kelompokumur_nama as kelompokumur_nama',
				'kelompokumur_m.kelompokumur_namalainnya as kelompokumur_namalainnya',
				'kelompokumur_m.kelompokumur_minimal as kelompokumur_minimal',
				'kelompokumur_m.kelompokumur_maksimal as kelompokumur_maksimal'
			])
			->orderBy('pasien_m.pasien_id','asc')
			->chunk(1100, function ($pasien_m) use ($arr) {
				foreach ($pasien_m as $value) {
					$namapasien = $value->nama_pasien  != '' && $value->nama_pasien ? ucwords(strtolower($value->nama_pasien)) : '-';
					$tempatlahir = $value->tempat_lahir != '' && $value->tempat_lahir ? ucwords(strtolower($value->tempat_lahir)) : '-';
					$jenisidentitas = $value->jenisidentitas != '' && $value->jenisidentitas ? $value->jenisidentitas : '-';
					$nomoridentitas = $value->no_identitas_pasien != '' && $value->no_identitas_pasien ? $value->no_identitas_pasien : '-';
					$jeniskelamin = $value->jeniskelamin != 'Undefined' && $value->jeniskelamin != '' && $value->jeniskelamin ? ucwords(strtolower($value->jeniskelamin)) : '-';
					$alamatpasien = $value->jeniskelamin != 'Undefined' && $value->alamat_pasien != '' && $value->alamat_pasien ? ucwords(strtolower($value->alamat_pasien)) : '-';

					if ($alamatpasien != '-') {
						$alamatpasien = str_replace("'", "", $alamatpasien);
					}
					$nomobilepasien = $value->no_mobile_pasien != '' && $value->no_mobile_pasien ? $value->no_mobile_pasien : '-';
					$agama = $value->agama != '' && $value->agama ? ucwords(strtolower($value->agama)) : '-';
					$statusperkawinan = $value->statusperkawinan != '' && $value->statusperkawinan ? ucwords(strtolower($value->statusperkawinan)) : '-';
					$golongandarah = $value->golongandarah != '' && $value->golongandarah ? $value->golongandarah : '-';

					$kelurahan_nama = $value->kelurahan_nama != '' && $value->kelurahan_nama ? ucwords(strtolower($value->kelurahan_nama)) : '-';
					$kecamatan_nama = $value->kecamatan_nama != '' && $value->kecamatan_nama ? ucwords(strtolower($value->kecamatan_nama)) : '-';
					$kabupaten_nama = $value->kabupaten_nama != '' && $value->kabupaten_nama ? ucwords(strtolower($value->kabupaten_nama)) : '-';
					$provinsi_nama = $value->propinsi_nama != '' && $value->propinsi_nama ? ucwords(strtolower($value->propinsi_nama)) : '-';

					$arry = array(
						'uuid' => Uuid::uuid4(),
						'rekam_medis' => $value->no_rekam_medik,
						'tahun' => date('Y'),
						'bulan' => date('m'),
						'angka_nol' => '000',
						'nomor' => 0,
						'nama' => $namapasien,
						'alias' => '-',
						'tempat_lahir' => $tempatlahir,
						'tanggal_lahir' => $value->tanggal_lahir,
						'jenis_identitas' => $jenisidentitas,
						'no_identitas' => $nomoridentitas,
						'email' => '-',
						'jenis_kelamin' => $jeniskelamin,
						'alamat' => $alamatpasien,
						'provinsi_id' => 0,
						'nama_provinsi' => $provinsi_nama,
						'kab_kota_id' => 0,
						'nama_kab_kota' => $kabupaten_nama,
						'kecamatan_id' => 0,
						'nama_kecamatan' => $kecamatan_nama,
						'kelurahan_id' => 0,
						'nama_kelurahan' => $kelurahan_nama,
						'kodepos' => '-',
						'rt_rw' => '-',
						'no_handphone' => $nomobilepasien,
						'agama' => $agama,
						'suku' => '-',
						'status_pernikahan' => $statusperkawinan,
						'pekerjaan' => '-',
						'pendidikan_terakhir' => '-',
						'golongan_darah' => '-',
						'nama_ayah' => '-',
						'nama_ibu' => '-',
						'pasien_old_id' => $value->pasien_id,
						'sebutan' => $value->nama_depan,
						'kelompok_umur_id' => 0,
						'kelompok_umur_nama' => $value->kelompokumur_nama,
						'kelompok_umur_posisi' => $value->kelompokumur_namalainnya,
						'kelompok_umur_minimal' => $value->kelompokumur_minimal,
						'kelompok_umur_maksimal' => $value->kelompokumur_maksimal,
					);
					DB::table('pasien')->insert($arry);
				}
			});
		return "Pasien => Alhamdulillahirabbil'aalamiin";
  }

	public function masterDanHargaObatAlkes(Request $request)
  {
		date_default_timezone_set("Asia/Jakarta");
		set_time_limit(2400);
		$arr = array();
		$obatalkes_m = DB::connection('pgsql_second')
			->table('obatalkes_m')
			->leftJoin('jenisobatalkes_m', 'obatalkes_m.jenisobatalkes_id', '=', 'jenisobatalkes_m.jenisobatalkes_id')
			->leftJoin('satuankecil_m', 'obatalkes_m.satuankecil_id', '=', 'satuankecil_m.satuankecil_id')
			->leftJoin('satuanbesar_m', 'obatalkes_m.satuanbesar_id', '=', 'satuanbesar_m.satuanbesar_id')
			->select([
				'obatalkes_m.obatalkes_id as obatalkes_id',
				'jenisobatalkes_m.jenisobatalkes_nama as jenisobatalkes_nama',
				'satuankecil_m.satuankecil_nama as satuankecil_nama',
				'satuanbesar_m.satuanbesar_nama as satuanbesar_nama',
				'obatalkes_m.obatalkes_nama as obatalkes_nama',
				'obatalkes_m.obatalkes_golongan as obatalkes_golongan',
				'obatalkes_m.obatalkes_kategori as obatalkes_kategori',
				'obatalkes_m.kemasanbesar as kemasan_besar',
				'obatalkes_m.ppn_persen as ppn_persen',
				'obatalkes_m.harganetto as harganetto',
				'obatalkes_m.hargajual as hargajual',
				'obatalkes_m.marginresep as marginresep',
				'obatalkes_m.hjaresep as hjaresep',
				'obatalkes_m.marginnonresep as marginnonresep',
				'obatalkes_m.hjanonresep as hjanonresep',
				'obatalkes_m.hpp as hpp',
				'obatalkes_m.discount as discount',
				'obatalkes_m.formularium as formularium',
				'obatalkes_m.minimalstok as minimalstok',
				'obatalkes_m.obatalkes_aktif as obatalkes_aktif'
			])
			->orderBy('obatalkes_m.obatalkes_id','asc')
			->chunk(1100, function ($obatalkes_m) use ($arr) {
				foreach ($obatalkes_m as $value) {
					$obat_uuid = Uuid::uuid4();
					$arry = array(
						'uuid' => $obat_uuid,
						'nama' => $value->obatalkes_nama && $value->obatalkes_nama != 'Undefined' && $value->obatalkes_nama != '' ? ucwords(strtolower($value->obatalkes_nama)) : '-',
						'keterangan' => '-',
						'satuan_uuid_besar' => '-',
						'nama_satuan_besar' => $value->satuanbesar_nama && $value->satuanbesar_nama != 'Undefined' && $value->satuanbesar_nama != '' ? ucwords(strtolower($value->satuanbesar_nama)) : '-',
						'satuan_uuid_kecil' => '-',
						'nama_satuan_kecil' => $value->satuankecil_nama && $value->satuankecil_nama != 'Undefined' && $value->satuankecil_nama != '' ? ucwords(strtolower($value->satuankecil_nama)) : '-',
						'hitung_besar' => '1',
						'hitung_kecil' => $value->kemasan_besar,
						'kategori' => $value->obatalkes_kategori && $value->obatalkes_kategori != 'Undefined' && $value->obatalkes_kategori != '' ? ucwords(strtolower($value->obatalkes_kategori)) : '-',
						'formularium' => $value->formularium && $value->formularium != 'Undefined' && $value->formularium != '' ? ucwords(strtolower($value->formularium)) : '-',
						'golongan' => $value->obatalkes_golongan && $value->obatalkes_golongan != 'Undefined' && $value->obatalkes_golongan != '' ? ucwords(strtolower($value->obatalkes_golongan)) : '-',
						'jenis' => $value->jenisobatalkes_nama && $value->jenisobatalkes_nama != 'Undefined' && $value->jenisobatalkes_nama != '' ? ucwords(strtolower($value->jenisobatalkes_nama)) : '-',
						'satuan_kekuatan' => '-',
						'jumlah_kekuatan' => 0,
						'min_stock' => $value->minimalstok && $value->minimalstok != 'Undefined' && $value->minimalstok != '' ? $value->minimalstok : 0,
						'obatalkes_old_id' => $value->obatalkes_id && $value->obatalkes_id != 'Undefined' && $value->obatalkes_id != '' ? $value->obatalkes_id : 0,
						'delete_soft' => $value->obatalkes_aktif ? 1 : 0,
					);
					DB::table('obat')->insert($arry);
					$arry = array(
						'uuid' => Uuid::uuid4(),
						'obat_uuid' => $obat_uuid,
						'nama' => $value->obatalkes_nama && $value->obatalkes_nama != 'Undefined' && $value->obatalkes_nama != '' ? ucwords(strtolower($value->obatalkes_nama)) : '-',
						'satuan_uuid_besar' => '-',
						'nama_satuan_besar' => $value->satuanbesar_nama && $value->satuanbesar_nama != 'Undefined' && $value->satuanbesar_nama != '' ? ucwords(strtolower($value->satuanbesar_nama)) : '-',
						'satuan_uuid_kecil' => '-',
						'nama_satuan_kecil' => $value->satuankecil_nama && $value->satuankecil_nama != 'Undefined' && $value->satuankecil_nama != '' ? ucwords(strtolower($value->satuankecil_nama)) : '-',
						'hitung_besar' => '1',
						'hitung_kecil' => $value->kemasan_besar,
						'kategori' => $value->obatalkes_kategori && $value->obatalkes_kategori != 'Undefined' && $value->obatalkes_kategori != '' ? ucwords(strtolower($value->obatalkes_kategori)) : '-',
						'formularium' => $value->formularium && $value->formularium != 'Undefined' && $value->formularium != '' ? ucwords(strtolower($value->formularium)) : '-',
						'golongan' => $value->obatalkes_golongan && $value->obatalkes_golongan != 'Undefined' && $value->obatalkes_golongan != '' ? ucwords(strtolower($value->obatalkes_golongan)) : '-',
						'jenis' => $value->jenisobatalkes_nama && $value->jenisobatalkes_nama != 'Undefined' && $value->jenisobatalkes_nama != '' ? ucwords(strtolower($value->jenisobatalkes_nama)) : '-',
						'satuan_kekuatan' => '-',
						'jumlah_kekuatan' => 0,
						'harga_netto' => $value->harganetto && $value->harganetto != 'Undefined' && $value->harganetto != '' ? $value->harganetto : 0,
						'harga_netto_discount' => $value->discount && $value->discount != 'Undefined' && $value->discount != '' ? $value->discount : 0,
						'harga_netto_ppn' => $value->ppn_persen && $value->ppn_persen != 'Undefined' && $value->ppn_persen != '' ? $value->ppn_persen : 0,
						'hpp' => $value->hpp && $value->hpp != 'Undefined' && $value->hpp != '' ? $value->hpp : 0,
						'margin_resep' => $value->marginresep && $value->marginresep != 'Undefined' && $value->marginresep != '' ? $value->marginresep : 0,
						'margin_non_resep' => $value->marginnonresep && $value->marginnonresep != 'Undefined' && $value->marginnonresep != '' ? $value->marginnonresep : 0,
						'hja_resep' => $value->hjaresep && $value->hjaresep != 'Undefined' && $value->hjaresep != '' ? $value->hjaresep : 0,
						'hja_non_resep' => $value->hjanonresep && $value->hjanonresep != 'Undefined' && $value->hjanonresep != '' ? $value->hjanonresep : 0,
						'hja_resep_besar' => $value->hjaresep && $value->hjaresep != 'Undefined' && $value->hjaresep != '' ? $value->hjaresep : 0,
						'hja_non_resep_besar' => $value->hjanonresep && $value->hjanonresep != 'Undefined' && $value->hjanonresep != '' ? $value->hjanonresep : 0,
						'last_update' => '-',
						'keterangan' => '-',
					);
					DB::table('harga_obat')->insert($arry);
				}
			});
		
		return "Master dan Harga Obat dan Alkes => Alhamdulillahirabbil'aalamiin";
	}

	public function stockopname(Request $request) {
		// Apotek Pelayanan => , 
		// Klinik Penyakit Mata => , 
		// Gudang Farmasi => , 
		// Bedah Sentral => , 

		date_default_timezone_set("Asia/Jakarta");
		set_time_limit(2400);
		$arr = array();
		$i = 0; $jumlah = 0;
		//$collection = new Collection();
		$stokobatalkes_t = DB::connection('pgsql_second')
			->table('stokobatalkes_t')
			->leftJoin('ruangan_m', 'stokobatalkes_t.ruangan_id', '=', 'ruangan_m.ruangan_id')
			->leftJoin('obatalkes_m', 'stokobatalkes_t.obatalkes_id', '=', 'obatalkes_m.obatalkes_id')
			->leftJoin('jenisobatalkes_m', 'obatalkes_m.jenisobatalkes_id', '=', 'jenisobatalkes_m.jenisobatalkes_id')
			->leftJoin('satuankecil_m', 'stokobatalkes_t.satuankecil_id', '=', 'satuankecil_m.satuankecil_id')
			->leftJoin('satuanbesar_m', 'obatalkes_m.satuanbesar_id', '=', 'satuanbesar_m.satuanbesar_id')
			//->whereNotNull('stokobatalkes_t.tglstok_out')
			->select([
				'stokobatalkes_t.stokobatalkes_id as stokobatalkes_id',
				'ruangan_m.ruangan_nama as ruangan_nama',
				'obatalkes_m.obatalkes_nama as obatalkes_nama',
				'obatalkes_m.obatalkes_golongan as obatalkes_golongan',
				'obatalkes_m.obatalkes_kategori as obatalkes_kategori',
				'obatalkes_m.formularium as formularium',
				'obatalkes_m.kemasanbesar as kemasan_besar',
				'jenisobatalkes_m.jenisobatalkes_nama as jenisobatalkes_nama',
				'satuankecil_m.satuankecil_nama as satuankecil_nama',
				'satuanbesar_m.satuanbesar_nama as satuanbesar_nama',
				'stokobatalkes_t.qtystok_current as qtystok_current',
				'stokobatalkes_t.update_time as update_time',
			])
			->orderBy('ruangan_m.ruangan_nama','asc')
			->orderBy('obatalkes_m.obatalkes_nama','asc')
			->orderBy('stokobatalkes_t.update_time','asc')
			->orderBy('stokobatalkes_t.stokobatalkes_id','asc')
			// ->limit(200)->get();
			// return $stokobatalkes_t;
			->chunk(1100, function ($stokobatalkes_t) use ($arr, $i, $jumlah) {
				$temp = null;
				$next = false;
				foreach ($stokobatalkes_t as $value) {
					$next = false;
					if ($i == 0) { $temp = $value; }
					else {
						if ($temp->obatalkes_nama != $value->obatalkes_nama) { $next = true; }
						
						if ($next) {
							$unit_uuid = '';
							$nama_unit = '';
							if ($temp->ruangan_nama == 'Apotek Pelayanan'){
								$unit_uuid = 'd88a34c8-f377-4477-88bc-643a8e0e041b';
								$nama_unit = 'Apotek';
							}
							// else if ($temp->ruangan_nama == 'Klinik Penyakit Mata'){
							// 	$unit_uuid = '60df3cd5-57c2-4f05-b5fa-dffba34400dc';
							// 	$nama_unit = 'Rawat Jalan';
							// }
							else if ($temp->ruangan_nama == 'Gudang Farmasi'){
								$unit_uuid = 'bc0582ff-ce98-45f4-b361-ecef5b686a0f';
								$nama_unit = 'Gudang Farmasi';
							}
							// else if ($temp->ruangan_nama == 'Bedah Sentral'){
							// 	$unit_uuid = 'c7887937-6e20-45dd-b437-f0ee6dccc1fa';
							// 	$nama_unit = 'Bedah / Operasi';
							// }
							$jumlah += $temp->qtystok_current && $temp->qtystok_current != 'Undefined' && $temp->qtystok_current != '' ? $temp->qtystok_current : 0;
							$arry = array(
								'uuid' => Uuid::uuid4(),
								'obat_uuid' => '-',
								'nama' => $temp->obatalkes_nama && $temp->obatalkes_nama != 'Undefined' && $temp->obatalkes_nama != '' ? ucwords(strtolower($temp->obatalkes_nama)) : '-',
								'kategori' => $temp->obatalkes_kategori && $temp->obatalkes_kategori != 'Undefined' && $temp->obatalkes_kategori != '' ? ucwords(strtolower($temp->obatalkes_kategori)) : '-',
								'formularium' => $temp->formularium && $temp->formularium != 'Undefined' && $temp->formularium != '' ? ucwords(strtolower($temp->formularium)) : '-',
								'golongan' => $temp->obatalkes_golongan && $temp->obatalkes_golongan != 'Undefined' && $temp->obatalkes_golongan != '' ? ucwords(strtolower($temp->obatalkes_golongan)) : '-',
								'jenis' => $temp->jenisobatalkes_nama && $temp->jenisobatalkes_nama != 'Undefined' && $temp->jenisobatalkes_nama != '' ? ucwords(strtolower($temp->jenisobatalkes_nama)) : '-',
								'satuan_kekuatan' => '-',
								'jumlah_kekuatan' => 0,
								'satuan_uuid_besar' => '-',
								'nama_satuan_besar' => $temp->satuanbesar_nama && $temp->satuanbesar_nama != 'Undefined' && $temp->satuanbesar_nama != '' ? ucwords(strtolower($temp->satuanbesar_nama)) : '-',
								'satuan_uuid_kecil' => '-',
								'nama_satuan_kecil' => $temp->satuankecil_nama && $temp->satuankecil_nama != 'Undefined' && $temp->satuankecil_nama != '' ? ucwords(strtolower($temp->satuankecil_nama)) : '-',
								'hitung_besar' => '1',
								'hitung_kecil' => $value->kemasan_besar,
								'jumlah_kecil' => $jumlah,
								'jumlah_besar' => $jumlah/$value->kemasan_besar,
								'unit_uuid' => $unit_uuid,
								'nama_unit' => $nama_unit,
							);
							DB::table('stock_opname')->insert($arry);
							if ($i < (count($stokobatalkes_t)-1)) {$temp = $value; $jumlah = 0; }
						}
						else { 
							$jumlah += $temp->qtystok_current && $temp->qtystok_current != 'Undefined' && $temp->qtystok_current != '' ? $temp->qtystok_current : 0; 
							$temp = $value; 
						}
					}

					if ($i == (count($stokobatalkes_t)-1)) {
						$unit_uuid = '';
						$nama_unit = '';
						if ($value->ruangan_nama == 'Apotek Pelayanan'){
							$unit_uuid = 'd88a34c8-f377-4477-88bc-643a8e0e041b';
							$nama_unit = 'Apotek';
						}
						// else if ($value->ruangan_nama == 'Klinik Penyakit Mata'){
						// 	$unit_uuid = '60df3cd5-57c2-4f05-b5fa-dffba34400dc';
						// 	$nama_unit = 'Rawat Jalan';
						// }
						else if ($value->ruangan_nama == 'Gudang Farmasi'){
							$unit_uuid = 'bc0582ff-ce98-45f4-b361-ecef5b686a0f';
							$nama_unit = 'Gudang Farmasi';
						}
						// else if ($value->ruangan_nama == 'Bedah Sentral'){
						// 	$unit_uuid = 'c7887937-6e20-45dd-b437-f0ee6dccc1fa';
						// 	$nama_unit = 'Bedah / Operasi';
						// }
						$jumlah += $temp->qtystok_current && $temp->qtystok_current != 'Undefined' && $temp->qtystok_current != '' ? $temp->qtystok_current : 0;
						$arry = array(
							'uuid' => Uuid::uuid4(),
							'obat_uuid' => '-',
							'nama' => $value->obatalkes_nama && $value->obatalkes_nama != 'Undefined' && $value->obatalkes_nama != '' ? ucwords(strtolower($value->obatalkes_nama)) : '-',
							'kategori' => $value->obatalkes_kategori && $value->obatalkes_kategori != 'Undefined' && $value->obatalkes_kategori != '' ? ucwords(strtolower($value->obatalkes_kategori)) : '-',
							'formularium' => $value->formularium && $value->formularium != 'Undefined' && $value->formularium != '' ? ucwords(strtolower($value->formularium)) : '-',
							'golongan' => $value->obatalkes_golongan && $value->obatalkes_golongan != 'Undefined' && $value->obatalkes_golongan != '' ? ucwords(strtolower($value->obatalkes_golongan)) : '-',
							'jenis' => $value->jenisobatalkes_nama && $value->jenisobatalkes_nama != 'Undefined' && $value->jenisobatalkes_nama != '' ? ucwords(strtolower($value->jenisobatalkes_nama)) : '-',
							'satuan_kekuatan' => '-',
							'jumlah_kekuatan' => 0,
							'satuan_uuid_besar' => '-',
							'nama_satuan_besar' => $value->satuanbesar_nama && $value->satuanbesar_nama != 'Undefined' && $value->satuanbesar_nama != '' ? ucwords(strtolower($value->satuanbesar_nama)) : '-',
							'satuan_uuid_kecil' => '-',
							'nama_satuan_kecil' => $value->satuankecil_nama && $value->satuankecil_nama != 'Undefined' && $value->satuankecil_nama != '' ? ucwords(strtolower($value->satuankecil_nama)) : '-',
							'hitung_besar' => '1',
							'hitung_kecil' => $value->kemasan_besar,
							'jumlah_kecil' => $jumlah,
							'jumlah_besar' => $jumlah/$value->kemasan_besar,
							'unit_uuid' => $unit_uuid,
							'nama_unit' => $nama_unit,
						);
						DB::table('stock_opname')->insert($arry);
					}
					$i += 1;
				}
			});

		return "Stockopname Obat dan Alkes => Alhamdulillahirabbil'aalamiin";
	}

	public function logresepold(Request $request) {

		date_default_timezone_set("Asia/Jakarta");
		set_time_limit(2400);
		$arr = array();
		$obatalkespasien_t = DB::connection('pgsql_second')
			->table('obatalkespasien_t')
			->leftJoin('penjaminpasien_m', 'obatalkespasien_t.penjamin_id', '=', 'penjaminpasien_m.penjamin_id')
			->leftJoin('satuankecil_m', 'obatalkespasien_t.satuankecil_id', '=', 'satuankecil_m.satuankecil_id')
			->leftJoin('obatalkes_m', 'obatalkespasien_t.obatalkes_id', '=', 'obatalkes_m.obatalkes_id')
			->leftJoin('pasien_m', 'obatalkespasien_t.pasien_id', '=', 'pasien_m.pasien_id')
			->select([
				'obatalkespasien_t.satuankecil_id as satuankecil_id',
				'obatalkespasien_t.pendaftaran_id as pendaftaran_id',
				'obatalkespasien_t.obatalkes_id as obatalkes_id',
				'obatalkespasien_t.pasien_id as pasien_id',
				'obatalkespasien_t.penjamin_id as penjamin_id',
				'obatalkespasien_t.tglpelayanan as tglpelayanan',
				'obatalkespasien_t.r as r',
				'obatalkespasien_t.rke as rke',
				'obatalkespasien_t.jmlkemasan_oa as jmlkemasan_oa',
				'obatalkespasien_t.qty_oa as qty_oa',
				'obatalkespasien_t.hargasatuan_oa as hargasatuan_oa',
				'obatalkespasien_t.signa_oa as signa_oa',
				'obatalkespasien_t.harganetto_oa as harganetto_oa',
				'obatalkespasien_t.hargajual_oa as hargajual_oa',
				'penjaminpasien_m.penjamin_nama as penjamin_nama',
				'satuankecil_m.satuankecil_nama as satuankecil_nama',
				'obatalkes_m.obatalkes_nama as obatalkes_nama',
				'pasien_m.nama_pasien as nama_pasien'
			])
			->orderBy('obatalkespasien_t.obatalkespasien_id','asc')
			->chunk(1100, function ($obatalkespasien_t) use ($arr) {
				foreach ($obatalkespasien_t as $value) {
					$obat_uuid = Uuid::uuid4();
					$arry = array(
						'uuid' => $obat_uuid,
						'satuankecil_id' => $value->satuankecil_id,
						'satuankecil_nama' => $value->satuankecil_nama,
						'pendaftaran_id' => $value->pendaftaran_id,
						'obatalkes_id' => $value->obatalkes_id,
						'obatalkes_nama' => $value->obatalkes_nama,
						'pasien_id' => $value->pasien_id,
						'nama_pasien' => $value->nama_pasien,
						'r' => $value->r,
						'rke' => $value->rke,
						'jmlkemasan_oa' => $value->jmlkemasan_oa,
						'qty_oa' => $value->qty_oa,
						'hargasatuan_oa' => $value->hargasatuan_oa,
						'harganetto_oa' => $value->harganetto_oa,
						'hargajual_oa' => $value->hargajual_oa,
						'penjamin_id' => $value->penjamin_id,
						'penjamin_nama' => $value->penjamin_nama,
						'tglpelayanan' => $value->tglpelayanan,
						'signa_oa' => $value->signa_oa
					);
					DB::table('log_resep_old')->insert($arry);
				}
			});
		return "Log penjualan Obat dan Alkes => Alhamdulillahirabbil'aalamiin";
	}

	public function pendaftaranold(Request $request) {

		date_default_timezone_set("Asia/Jakarta");
		set_time_limit(2400);
		$arr = array();
		$pendaftaran_t = DB::connection('pgsql_second')
			->table('pendaftaran_t')
			->leftJoin('penjaminpasien_m', 'pendaftaran_t.penjamin_id', '=', 'penjaminpasien_m.penjamin_id')
			->leftJoin('pasien_m', 'pendaftaran_t.pasien_id', '=', 'pasien_m.pasien_id')
			->leftJoin('carabayar_m', 'pendaftaran_t.carabayar_id', '=', 'carabayar_m.carabayar_id')
			->leftJoin('caramasuk_m', 'pendaftaran_t.caramasuk_id', '=', 'caramasuk_m.caramasuk_id')
			->select([
				'pendaftaran_t.pendaftaran_id as pendaftaran_id',
				'pendaftaran_t.penjamin_id as penjamin_id',
				'penjaminpasien_m.penjamin_nama as penjamin_nama',
				'pendaftaran_t.caramasuk_id as caramasuk_id',
				'caramasuk_m.caramasuk_nama as caramasuk_nama',
				'pendaftaran_t.pasien_id as pasien_id',
				'pasien_m.nama_pasien as nama_pasien',
				'pendaftaran_t.carabayar_id as carabayar_id',
				'carabayar_m.carabayar_nama as carabayar_nama',
				'pendaftaran_t.no_pendaftaran as no_pendaftaran',
				'pendaftaran_t.tgl_pendaftaran as tgl_pendaftaran',
				'pendaftaran_t.statuspasien as statuspasien',
				'pendaftaran_t.statusmasuk as statusmasuk',
				'pendaftaran_t.tglselesaiperiksa as tglselesaiperiksa'
			])
			->orderBy('pendaftaran_t.pendaftaran_id','asc')
			->chunk(1100, function ($pendaftaran_t) use ($arr) {
				foreach ($pendaftaran_t as $value) {
					$obat_uuid = Uuid::uuid4();
					$arry = array(
						'uuid' => $obat_uuid,
						'pendaftaran_id' => $value->pendaftaran_id,
						'penjamin_id' => $value->penjamin_id,
						'penjamin_nama' => $value->penjamin_nama,
						'caramasuk_id' => $value->caramasuk_id,
						'caramasuk_nama' => $value->caramasuk_nama,
						'pasien_id' => $value->pasien_id,
						'nama_pasien' => $value->nama_pasien,
						'carabayar_id' => $value->carabayar_id,
						'carabayar_nama' => $value->carabayar_nama,
						'no_pendaftaran' => $value->no_pendaftaran,
						'statuspasien' => $value->statuspasien,
						'statusmasuk' => $value->statusmasuk,
						'tgl_pendaftaran' => $value->tgl_pendaftaran,
						'tglselesaiperiksa' => $value->tglselesaiperiksa
					);
					DB::table('pendaftaran_old')->insert($arry);
				}
			});
		return "Pendaftaran Old => Alhamdulillahirabbil'aalamiin";
	}

}
