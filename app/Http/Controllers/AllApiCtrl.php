<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Provinsi;
use App\Models\KabKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Label;
use App\Models\Asuransi;
use App\Models\Carabayar;
use App\Models\Tarif;
use App\Models\Icd9;
use App\Models\Icd10;
use App\Models\Layanan;
use App\Models\Ruangan;
use App\Models\Pasien;

class AllApiCtrl extends Controller
{

	private $take = 10, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		//$this->error = PenggunaHelp::acl(); 
	}

	public function patch(Request $request) {
		set_time_limit(3000);
		$alltindakan = array();
		$kamarinap = array();
		$paketbedah = array();
		$carabayartindakanrawatjalan = array();
		$tindakanrawatjalan = array();
		$carabayartindakannonbedah = array();
		$tindakannonbedah = array();
		$carabayartindakanbedah = array();
		$tindakanbedah = array();
		$jeniskamar = array(); $obat = array(); $obat2 = array(); $obat3 = array(); $obat4 = array();  $obatgudang = array(); $hargagudang = array(); $apotek = array(); $supplier = array();   $ocularsinistravisus = array();
		$oculardextravisus = array();
		$oculardextrabcva2= array();
		$ocularsinistrabcva2 = array();
		$oculardextrapinhole = array();
		$ocularsinistrapinhole = array();
		$dokter = array();
		$dokterumum = array();
		$icd9 = array(); $icd10 = array(); $satuan = array(); $ruangans = array();
		$carabayar = array(); $asuransi = array(); $layanan = array(); $tarif = array();
		$provinsi = array(); $kabkota = array(); $kecamatan = array(); $kelurahan = array();
		
		if ($request->position == 'all') {
			$kamarinap = $this->kamarinap();
			$alltindakan = $this->alltindakan();
			$paketbedah = $this->paketbedah();
			$carabayartindakanrawatjalan = $this->carabayartindakanrawatjalan();
			$tindakanrawatjalan = $this->tindakanrawatjalan();
			$carabayartindakannonbedah = $this->carabayartindakannonbedah();
			$tindakannonbedah = $this->tindakannonbedah();
			$carabayartindakanbedah = $this->carabayartindakanbedah();
			$tindakanbedah = $this->tindakanbedah();
			$jeniskamar = $this->jeniskamar(); $obat = $this->obat();$obat2 = $this->obat2(); $obat3 = $this->obat3(); $obat4 = $this->obat(); $hargagudang = $this->hargagudang(); $obatgudang = $this->obatgudang(); $apotek = $this->apotek(); $apotekracikan = $this->apotekracikan(); $supplier = $this->supplier();
			$dokter = $this->dokter(); $dokterumum = $this->dokterumum();
			$icd9 = $this->icd9(); $icd10 = $this->icd10();
			$satuan = $this->satuan(); $ruangans = $this->ruangans(); $carabayar = $this->carabayar();
			$asuransi = $this->asuransi(); $layanan = $this->layanan(); $tarif = $this->tarif();
			$provinsi = $this->provinsi(); $kabkota = $this->kabkota();
			$kecamatan = $this->kecamatan(); $kelurahan = $this->kelurahan();
			$ocularsinistravisus = $this->ocularsinistravisus();
			$oculardextravisus = $this->ocularsinistravisus();
			$ocularsinistrabcva2 = $this->ocularsinistravisus();
			$oculardextrabcva2 = $this->ocularsinistravisus();
			$oculardextrapinhole = $this->ocularsinistrapinhole();
			$ocularsinistrapinhole = $this->ocularsinistrapinhole();
		}
		else if ($request->position == 'kamarinap') { $kamarinap = $this->kamarinap(); }
		else if ($request->position == 'alltindakan') { $alltindakan = $this->alltindakan(); }
		else if ($request->position == 'paketbedah') { $paketbedah = $this->paketbedah(); }
		else if ($request->position == 'carabayartindakanrawatjalan') { $carabayartindakanrawatjalan = $this->carabayartindakanrawatjalan(); }
		else if ($request->position == 'tindakanrawatjalan') { $tindakanrawatjalan = $this->tindakanrawatjalan(); }
		else if ($request->position == 'carabayartindakannonbedah') { $carabayartindakannonbedah = $this->carabayartindakannonbedah(); }
		else if ($request->position == 'tindakannonbedah') { $tindakannonbedah = $this->tindakannonbedah(); }
		else if ($request->position == 'carabayartindakanbedah') { $carabayartindakanbedah = $this->carabayartindakanbedah(); }
		else if ($request->position == 'tindakanbedah') { $tindakanbedah = $this->tindakanbedah(); }
		else if ($request->position == 'obat') { $obat = $this->obat(); }
		else if ($request->position == 'obat2') { $obat2 = $this->obat2(); }
		else if ($request->position == 'obat3') { $obat3 = $this->obat3(); }
		else if ($request->position == 'obat4') { $obat3 = $this->obat(); }
		else if ($request->position == 'jeniskamar') { $jeniskamar = $this->jeniskamar(); }
		else if ($request->position == 'obatgudang') { $obatgudang = $this->obatgudang(); }
		else if ($request->position == 'hargagudang') { $hargagudang = $this->hargagudang(); }
		else if ($request->position == 'apotek') { $apotek = $this->apotek(); }
		else if ($request->position == 'apotekracikan') { $apotek = $this->apotekracikan(); }
		else if ($request->position == 'supplier') { $supplier = $this->supplier(); }
		else if ($request->position == 'dokter') { $dokter = $this->dokter(); }
		else if ($request->position == 'dokterumum') { $dokterumum = $this->dokterumum(); }
		else if ($request->position == 'icd9') { $icd9 = $this->icd9(); }
		else if ($request->position == 'icd10') { $icd10 = $this->icd10(); }
		else if ($request->position == 'satuan') { $satuan = $this->satuan(); }
		else if ($request->position == 'ruangans') { $ruangans = $this->ruangans(); }
		else if ($request->position == 'carabayar') { $carabayar = $this->carabayar(); }
		else if ($request->position == 'asuransi') { $asuransi = $this->asuransi(); }
		else if ($request->position == 'layanan') { $layanan = $this->layanan(); }
		else if ($request->position == 'tarif') { $tarif = $this->tarif(); }
		else if ($request->position == 'provinsi') { $provinsi = $this->provinsi(); }
		else if ($request->position == 'kabkota') { $kabkota = $this->kabkota(); }
		else if ($request->position == 'kecamatan') { $kecamatan = $this->kecamatan(); }
		else if ($request->position == 'kelurahan') { $kelurahan = $this->kelurahan(); }
		else if ($request->position == 'ocularsinistravisus') { $ocularsinistravisus = $this->ocularsinistravisus(); }
		else if ($request->position == 'oculardextravisus') { $oculardextravisus = $this->ocularsinistravisus(); }
		else if ($request->position == 'oculardextrabcva2') { $oculardextrabcva2 = $this->ocularsinistravisus(); }
		else if ($request->position == 'ocularsinistrabcva2') { $ocularsinistrabcva2 = $this->ocularsinistravisus(); }
		else if ($request->position == 'oculardextrapinhole') { $oculardextrabcva2 = $this->ocularsinistrapinhole(); }
		else if ($request->position == 'ocularsinistrapinhole') { $ocularsinistrabcva2 = $this->ocularsinistrapinhole(); }

		return response()->json([
			'kamarinap' => $kamarinap,
			'alltindakan' => $alltindakan,
			'paketbedah' => $paketbedah,
			'carabayartindakanrawatjalan' => $carabayartindakanrawatjalan,
			'tindakanrawatjalan' => $tindakanrawatjalan,
			'carabayartindakannonbedah' => $carabayartindakannonbedah,
			'tindakannonbedah' => $tindakannonbedah,
			'carabayartindakanbedah' => $carabayartindakanbedah,
			'tindakanbedah' => $tindakanbedah,
			'jeniskamar' => $jeniskamar,
			'obat' => $obat, 'obat2' => $obat2,  'obat3' => $obat3, 'obat4' => $obat4,   'obatgudang' => $obatgudang, 'hargagudang' => $hargagudang, 'apotek' => $apotek, 'apotekracikan' => $apotekracikan, 'supplier' => $supplier, 'dokter' => $dokter, 
			'dokterumum' => $dokterumum,
			'icd9' => $icd9, 'icd10' => $icd10, 'satuan' => $satuan, 'ruangans' => $ruangans,
			'carabayar' => $carabayar, 'asuransi' => $asuransi, 'layanan' => $layanan,
			'tarif' => $tarif, 'provinsi' => $provinsi, 'kabkota' => $kabkota,
			'kecamatan' => $kecamatan, 'kelurahan' => $kelurahan,
			'ocularsinistravisus' => $ocularsinistravisus,
			'oculardextravisus' => $oculardextravisus,
			'oculardextrabcva2' => $oculardextrabcva2,
			'ocularsinistrabcva2' => $ocularsinistrabcva2,
			'oculardextrapinhole' => $oculardextrapinhole,
			'ocularsinistrapinhole' => $ocularsinistrapinhole,
		]);
	}

	private function kamarinap() {
		return DB::table('kamar_inap')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function alltindakan() {
		return DB::table('tindakan_rawat_jalan')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function paketbedah() {
		return DB::table('paket_bedah')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function carabayartindakanrawatjalan() {
		return DB::table('carabayar_tindakan_rawat_jalan')
				->join('carabayar', 'carabayar.uuid', '=', 'carabayar_tindakan_rawat_jalan.carabayar_uuid')
				->orderBy('id','asc')
				->where('carabayar_tindakan_rawat_jalan.delete_soft', '=', '1')
				->where('carabayar.delete_soft', '=', '1')
			->select([
						'carabayar_tindakan_rawat_jalan.id as id',
						'carabayar_tindakan_rawat_jalan.uuid as uuid',
						'carabayar_tindakan_rawat_jalan.carabayar_uuid as carabayar_uuid',
						'carabayar_tindakan_rawat_jalan.carabayar_nama as carabayar_nama',
						'carabayar_tindakan_rawat_jalan.tindakan_rawat_jalan_uuid as tindakan_rawat_jalan_uuid',
						'carabayar_tindakan_rawat_jalan.nama_tindakan_rawat_jalan as nama_tindakan_rawat_jalan',
						'carabayar_tindakan_rawat_jalan.harga as harga',
						'carabayar_tindakan_rawat_jalan.status as status',
						'carabayar_tindakan_rawat_jalan.delete_soft as delete_soft',
						'carabayar_tindakan_rawat_jalan.created_at as created_at',
						'carabayar_tindakan_rawat_jalan.default as default',
						'carabayar_tindakan_rawat_jalan.jenis as jenis'
					])
				->get();
	}

	private function tindakanrawatjalan() {
		return DB::table('tindakan_rawat_jalan')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function carabayartindakannonbedah() {
		return DB::table('carabayar_tindakan_non_bedah')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function tindakannonbedah() {
		return DB::table('tindakan_non_bedah')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function carabayartindakanbedah() {
		return DB::table('carabayar_tindakan_bedah')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function tindakanbedah() {
		return DB::table('tindakan_bedah')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function jeniskamar() {
		return DB::table('jenis_kamar')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function obat() {
		return DB::table('obat')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}
	private function obat2() {
		return DB::table('obat')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}
	private function obat3() {
		return DB::table('obat')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}
	private function ocularsinistravisus() {
		return DB::table('master_visus')->orderBy('id','asc')->get();
	}
	private function ocularsinistrapinhole() {
		return DB::table('master_pinhole')->orderBy('id','asc')->get();
	}

	private function obatgudang() {
		return DB::table('stock_opname')->orderBy('id','asc')->where('nama_unit', '=', 'Gudang Farmasi')->where('delete_soft', '=', '1')->get();
	}

	private function hargagudang() {
		return DB::table('harga_obat')->join('stock_opname', 'harga_obat.obat_uuid', '=', 'stock_opname.obat_uuid')
									->orderBy('harga_obat.nama','asc')
									->where('harga_obat.delete_soft', '=', '1')
									->where('stock_opname.nama_unit', '=', 'Gudang Farmasi')
									->select([
										'harga_obat.id as harga_obat_id',
										'harga_obat.obat_uuid as obat_uuid',
										'harga_obat.nama as nama',
										'harga_obat.satuan_uuid_besar as satuan_uuid_besar',
										'harga_obat.nama_satuan_besar as nama_satuan_besar',
										'harga_obat.satuan_uuid_kecil as satuan_uuid_kecil',
										'harga_obat.nama_satuan_kecil as nama_satuan_kecil',
										'harga_obat.hitung_besar as hitung_besar',
										'harga_obat.hitung_kecil as hitung_kecil',
										'harga_obat.kategori as kategori',
										'harga_obat.formularium as formularium',
										'harga_obat.golongan as golongan',
										'harga_obat.jenis as jenis',
										'harga_obat.harga_netto as harga_netto',
										'harga_obat.harga_netto_discount as harga_netto_discount',
										'harga_obat.harga_netto_ppn as harga_netto_ppn',
										'harga_obat.hpp as hpp',
										'harga_obat.margin_resep as margin_resep',
										'harga_obat.margin_non_resep as margin_non_resep',
										'harga_obat.hja_resep as hja_resep',
										'harga_obat.hja_resep_besar as hja_resep_besar',
										'harga_obat.hja_non_resep as hja_non_resep',
										'harga_obat.hja_non_resep_besar as hja_non_resep_besar',
										'stock_opname.satuan_uuid_besar as satuan_uuid_besar',
										'stock_opname.nama_satuan_besar as nama_satuan_besar',
										'stock_opname.satuan_uuid_kecil as satuan_uuid_kecil',
										'stock_opname.nama_satuan_kecil as nama_satuan_kecil',
										'stock_opname.hitung_besar as hitung_besar',
										'stock_opname.hitung_kecil as hitung_kecil',
										'stock_opname.jumlah_kecil as jumlah_kecil',
										'stock_opname.jumlah_besar as jumlah_besar',
										'stock_opname.nama_unit as nama_unit'
									])
									//->where('stock_opname.jumlah_kecil', '>', 0)
									->get();
	}

	private function apotek() {
		return DB::table('harga_obat')->join('stock_opname', 'harga_obat.obat_uuid', '=', 'stock_opname.obat_uuid')
									->orderBy('harga_obat.nama','asc')
									->where('harga_obat.delete_soft', '=', '1')
									->where('stock_opname.nama_unit', '=', 'Apotek')
									->select([
										'harga_obat.id as harga_obat_id',
										'harga_obat.obat_uuid as obat_uuid',
										'harga_obat.nama as nama',
										'harga_obat.satuan_uuid_besar as satuan_uuid_besar',
										'harga_obat.nama_satuan_besar as nama_satuan_besar',
										'harga_obat.satuan_uuid_kecil as satuan_uuid_kecil',
										'harga_obat.nama_satuan_kecil as nama_satuan_kecil',
										'harga_obat.hitung_besar as hitung_besar',
										'harga_obat.hitung_kecil as hitung_kecil',
										'harga_obat.kategori as kategori',
										'harga_obat.formularium as formularium',
										'harga_obat.golongan as golongan',
										'harga_obat.jenis as jenis',
										'harga_obat.harga_netto as harga_netto',
										'harga_obat.harga_netto_discount as harga_netto_discount',
										'harga_obat.harga_netto_ppn as harga_netto_ppn',
										'harga_obat.hpp as hpp',
										'harga_obat.margin_resep as margin_resep',
										'harga_obat.margin_non_resep as margin_non_resep',
										'harga_obat.hja_resep as hja_resep',
										'harga_obat.hja_resep_besar as hja_resep_besar',
										'harga_obat.hja_non_resep as hja_non_resep',
										'harga_obat.hja_non_resep_besar as hja_non_resep_besar',
										'stock_opname.satuan_uuid_besar as satuan_uuid_besar',
										'stock_opname.nama_satuan_besar as nama_satuan_besar',
										'stock_opname.satuan_uuid_kecil as satuan_uuid_kecil',
										'stock_opname.nama_satuan_kecil as nama_satuan_kecil',
										'stock_opname.hitung_besar as hitung_besar',
										'stock_opname.hitung_kecil as hitung_kecil',
										'stock_opname.jumlah_kecil as jumlah_kecil',
										'stock_opname.jumlah_besar as jumlah_besar',
										'stock_opname.nama_unit as nama_unit'
									])
									->where('stock_opname.jumlah_kecil', '>', 0)
									->get();
	}


	private function apotekracikan() {
		return DB::table('harga_obat')->join('stock_opname', 'harga_obat.obat_uuid', '=', 'stock_opname.obat_uuid')
									->orderBy('harga_obat.nama','asc')
									->where('harga_obat.delete_soft', '=', '1')
									->where('stock_opname.nama_unit', '=', 'Apotek')
									->select([
										'harga_obat.id as harga_obat_id',
										'harga_obat.obat_uuid as obat_uuid',
										'harga_obat.nama as nama',
										'harga_obat.satuan_uuid_besar as satuan_uuid_besar',
										'harga_obat.nama_satuan_besar as nama_satuan_besar',
										'harga_obat.satuan_uuid_kecil as satuan_uuid_kecil',
										'harga_obat.nama_satuan_kecil as nama_satuan_kecil',
										'harga_obat.hitung_besar as hitung_besar',
										'harga_obat.hitung_kecil as hitung_kecil',
										'harga_obat.kategori as kategori',
										'harga_obat.formularium as formularium',
										'harga_obat.golongan as golongan',
										'harga_obat.jenis as jenis',
										'harga_obat.harga_netto as harga_netto',
										'harga_obat.harga_netto_discount as harga_netto_discount',
										'harga_obat.harga_netto_ppn as harga_netto_ppn',
										'harga_obat.hpp as hpp',
										'harga_obat.margin_resep as margin_resep',
										'harga_obat.margin_non_resep as margin_non_resep',
										'harga_obat.hja_resep as hja_resep',
										'harga_obat.hja_resep_besar as hja_resep_besar',
										'harga_obat.hja_non_resep as hja_non_resep',
										'harga_obat.hja_non_resep_besar as hja_non_resep_besar',
										'stock_opname.satuan_uuid_besar as satuan_uuid_besar',
										'stock_opname.nama_satuan_besar as nama_satuan_besar',
										'stock_opname.satuan_uuid_kecil as satuan_uuid_kecil',
										'stock_opname.nama_satuan_kecil as nama_satuan_kecil',
										'stock_opname.hitung_besar as hitung_besar',
										'stock_opname.hitung_kecil as hitung_kecil',
										'stock_opname.jumlah_kecil as jumlah_kecil',
										'stock_opname.jumlah_besar as jumlah_besar',
										'stock_opname.nama_unit as nama_unit'
									])
									->where('stock_opname.jumlah_kecil', '>', 0)
									->get();
	}

	private function supplier() {
		return DB::table('supplier')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function dokter() {
		return DB::table('biodata')->orderBy('id','asc')->where('delete_soft', '=', '1')->where('posisi_pengguna', '=', '8808')->get();
	}

	private function dokterumum() {
		return DB::table('biodata')->orderBy('id','asc')->where('delete_soft', '=', '1')->where('posisi_pengguna', '=', '8809')->get();
	}

	private function icd9() {
		return DB::table('icd_nine')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function icd10() {
		return DB::table('icd_ten')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function satuan() {
		return DB::table('satuan')->orderBy('id', 'asc')->where('delete_soft', '=', '1')->get();
	}

	private function ruangans() {
		return DB::table('ruangan')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function carabayar() {
		return DB::table('carabayar')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function asuransi() {
		return DB::table('asuransi')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function layanan() {
		return DB::table('layanan')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function tarif() {
		return DB::table('tarif')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function provinsi() {
		return DB::table('provinsi')->orderBy('id','asc')->where('delete_soft', '=', '1')->select(['uuid', 'id', 'nama'])->get();
	}

	private function kabkota() {
		return DB::table('kab_kota')->orderBy('id','asc')->where('delete_soft', '=', '1')->select(['uuid', 'id', 'nama', 'provinsi_id', 'nama_provinsi'])->get();
	}

	private function kecamatan() {
		return DB::table('kecamatan')->orderBy('id','asc')->where('delete_soft', '=', '1')->select(['uuid', 'id', 'nama', 'kab_kota_id', 'nama_kab_kota'])->get();
	}

	private function kelurahan() {
		$collection = new Collection;
		DB::table('kelurahan')->orderBy('id','asc')->where('delete_soft', '=', '1')
			->select(['uuid', 'id', 'nama', 'kecamatan_id', 'nama_kecamatan'])
			->chunk(5000, function ($kelurahan) use ($collection) {
				foreach ($kelurahan as $row) {
					$collection->push((object)[
						'uuid' => $row->uuid,
						'id' => $row->id,
						'nama' => $row->nama,
						'kecamatan_id' => $row->kecamatan_id,
						'nama_kecamatan' => $row->nama_kecamatan
					]);
				}
			});
		return $collection;
	}
	
	public function alamat(Request $request) {

		//if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		set_time_limit(2400);

		$listobat = DB::table('harga_obat')->join('stock_opname', 'harga_obat.obat_uuid', '=', 'stock_opname.obat_uuid')
									->orderBy('harga_obat.nama','asc')
									->where('harga_obat.delete_soft', '=', '1')
									->select([
										'harga_obat.id as harga_obat_id',
										'harga_obat.obat_uuid as obat_uuid',
										'harga_obat.nama as nama',
										'harga_obat.satuan_uuid_besar as satuan_uuid_besar',
										'harga_obat.nama_satuan_besar as nama_satuan_besar',
										'harga_obat.satuan_uuid_kecil as satuan_uuid_kecil',
										'harga_obat.nama_satuan_kecil as nama_satuan_kecil',
										'harga_obat.hitung_besar as hitung_besar',
										'harga_obat.hitung_kecil as hitung_kecil',
										'harga_obat.kategori as kategori',
										'harga_obat.formularium as formularium',
										'harga_obat.golongan as golongan',
										'harga_obat.harga_netto as harga_netto',
										'harga_obat.harga_netto_discount as harga_netto_discount',
										'harga_obat.harga_netto_ppn as harga_netto_ppn',
										'harga_obat.hpp as hpp',
										'harga_obat.margin_resep as margin_resep',
										'harga_obat.margin_non_resep as margin_non_resep',
										'harga_obat.hja_resep as hja_resep',
										'harga_obat.hja_non_resep as hja_non_resep',
										'stock_opname.satuan_uuid_besar as satuan_uuid_besar',
										'stock_opname.nama_satuan_besar as nama_satuan_besar',
										'stock_opname.satuan_uuid_kecil as satuan_uuid_kecil',
										'stock_opname.nama_satuan_kecil as nama_satuan_kecil',
										'stock_opname.hitung_besar as hitung_besar',
										'stock_opname.hitung_kecil as hitung_kecil',
										'stock_opname.jumlah_kecil as jumlah_kecil',
										'stock_opname.jumlah_besar as jumlah_besar'
									])->get();
		$obat = DB::table('obat')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$obat2 = DB::table('obat')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$obat3 = DB::table('obat')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$obat4 = DB::table('obat')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$ocularsinistravisus = DB::table('master_visus')->orderBy('id','asc')>get();
		$oculardextravisus = DB::table('master_visus')->orderBy('id','asc')>get();
		$oculardextrabcva2 = DB::table('master_visus')->orderBy('id','asc')>get();
		$ocularsinistrabcva2 = DB::table('master_visus')->orderBy('id','asc')>get();
		$oculardextrapinhole = DB::table('master_pinhole')->orderBy('id','asc')>get();
		$ocularsinistrapinhole = DB::table('master_pinhole')->orderBy('id','asc')>get();
		$supplier = DB::table('supplier')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$dokter = DB::table('biodata')->orderBy('id','asc')->where('delete_soft', '=', '1')->where('posisi_pengguna', '=', '8808')->get();
		$icd_nine = DB::table('icd_nine')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$icd_ten = DB::table('icd_ten')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$satuan = DB::table('satuan')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$ruangan = DB::table('ruangan')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$carabayar = DB::table('carabayar')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$asuransi = DB::table('asuransi')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$layanan = DB::table('layanan')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$tarif = DB::table('tarif')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		$ruangan = DB::table('ruangan')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();

		$provinsi = DB::table('provinsi')->orderBy('id','asc')->where('delete_soft', '=', '1')->select(['uuid', 'id', 'nama'])->get();
		$kabkota = DB::table('kab_kota')->orderBy('id','asc')->where('delete_soft', '=', '1')->select(['uuid', 'id', 'nama', 'provinsi_id', 'nama_provinsi'])->get();
		$kecamatan = DB::table('kecamatan')->orderBy('id','asc')->where('delete_soft', '=', '1')->select(['uuid', 'id', 'nama', 'kab_kota_id', 'nama_kab_kota'])->get();
		$collection = new Collection;
		$kelurahan = DB::table('kelurahan')->orderBy('id','asc')->where('delete_soft', '=', '1')
										->select(['uuid', 'id', 'nama', 'kecamatan_id', 'nama_kecamatan'])
										->chunk(5000, function ($kelurahan) use ($collection) {
											foreach ($kelurahan as $row) {
												$collection->push((object)[
													'uuid' => $row->uuid,
													'id' => $row->id,
													'nama' => $row->nama,
													'kecamatan_id' => $row->kecamatan_id,
													'nama_kecamatan' => $row->nama_kecamatan
												]);
											}
										});
		$kelurahan = $collection;
		return response()->json([
			'listobat' => $listobat,
			'obat' => $obat,
			'obat2' => $obat2,
			'obat3' => $obat3,
			'obat4' => $obat4,
			'ocularsinistravisus' => $ocularsinistravisus,
			'oculardextravisus' => $oculardextravisus,
			'oculardextrabcva2' => $oculardextrabcva2,
			'ocularsinistrabcva2' => $ocularsinistrabcva2,
			'oculardextrapinhole' => $oculardextrapinhole,
			'ocularsinistrapinhole' => $ocularsinistrapinhole,
			'supplier' => $supplier,
			'icd_nine' => $icd_nine,
			'icd_ten' => $icd_ten,
			'satuan' => $satuan,
			'ruangan' => $ruangan,
			'carabayar' => $carabayar,
			'asuransi' => $asuransi,
			'layanan' => $layanan,
			'tarif' => $tarif,
			'ruangan' => $ruangan,
			'provinsi' => $provinsi,
			'kabkota' => $kabkota,
			'kecamatan' => $kecamatan,
			'kelurahan' => $kelurahan,
			'dokter' => $dokter,
		]);
	}

	public function menu(Request $request) {
		$label = DB::table('hak_akses')->orderBy('id','asc')->where('delete_soft', '=', '1')
									->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid')))
									->get();
		return response()->json(['label' => $label]);
	}

	public function testing() {

		set_time_limit(2400);
		//ini_set('memory_limit', '-1');
		// $filePath = storage_path('app/pasien.csv');
    // $file = fopen($filePath, 'r');

    // $header = fgetcsv($file);

    // $users = [];
    // while ($row = fgetcsv($file)) {
    //     $users[] = array_combine($header, $row);
    // }

    // fclose($file);
		$arr = array();
		$collection = new Collection;
		$pasien_m = DB::table('pasien_m')
		->orderBy('pasien_id','asc')
		->select(['nama_pasien', 'tempat_lahir', 'jenisidentitas', 'no_identitas_pasien', 'jeniskelamin', 'alamat_pasien', 'no_mobile_pasien', 'agama', 'statusperkawinan', 'golongandarah', 'no_rekam_medik', 'tanggal_lahir'])
		->chunk(1000, function ($pasien_m) use ($arr) {
			
			foreach ($pasien_m as $value) {
				if ($value->jeniskelamin != 'Undefined') {
					
					$namapasien = $value->nama_pasien  != '' && $value->nama_pasien ? ucwords(strtolower($value->nama_pasien)) : '-';
					$tempatlahir = $value->tempat_lahir != '' && $value->tempat_lahir ? ucwords(strtolower($value->tempat_lahir)) : '-';
					$jenisidentitas = $value->jenisidentitas != '' && $value->jenisidentitas ? $value->jenisidentitas : '-';
					$nomoridentitas = $value->no_identitas_pasien != '' && $value->no_identitas_pasien ? $value->no_identitas_pasien : '-';
					$jeniskelamin = $value->jeniskelamin != '' && $value->jeniskelamin ? ucwords(strtolower($value->jeniskelamin)) : '-';
					$alamatpasien = $value->alamat_pasien != '' && $value->alamat_pasien ? ucwords(strtolower($value->alamat_pasien)) : '-';

					if ($alamatpasien != '-') {
						$alamatpasien = str_replace("'", "", $alamatpasien);
					}
					$nomobilepasien = $value->no_mobile_pasien != '' && $value->no_mobile_pasien ? $value->no_mobile_pasien : '-';
					$agama = $value->agama != '' && $value->agama ? ucwords(strtolower($value->agama)) : '-';
					$statusperkawinan = $value->statusperkawinan != '' && $value->statusperkawinan ? ucwords(strtolower($value->statusperkawinan)) : '-';
					$golongandarah = $value->golongandarah != '' && $value->golongandarah ? $value->golongandarah : '-';

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
						'nama_provinsi' => '-',
						'kab_kota_id' => 0,
						'nama_kab_kota' => '-',
						'kecamatan_id' => 0,
						'nama_kecamatan' => '-',
						'kelurahan_id' => 0,
						'nama_kelurahan' => '-',
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
					);
					DB::table('pasien')->insert($arry);	
					//$arr = array_merge($arr, $arry);
				}
			}
			//DB::table('pasien')->insert($arr);	
		});

    return 'Berhasil';
	}

}