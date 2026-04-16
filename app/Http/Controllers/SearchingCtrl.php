<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;

class SearchingCtrl extends Controller
{

	public function search(Request $request) {
		date_default_timezone_set("Asia/Jakarta");
		$data = array();
		$key = $request->key;
		if ($key == 'provinsi') {
			$data = $this->provinsi($request);
		}
		else if ($key == 'jenis_kamar') {
			$data = $this->jenis_kamar($request);
		}
		else if ($key == 'kab_kota') {
			$data = $this->kab_kota($request);
		}
		else if ($key == 'kecamatan') {
			$data = $this->kecamatan($request);
		}
		else if ($key == 'kelurahan') {
			$data = $this->kelurahan($request);
		}
		else if ($key == 'apotek') {
			$data = $this->apotek($request);
		}
		else if ($key == 'carabayar') {
			$data = $this->carabayar($request);
		}
		else if ($key == 'asuransi') {
			$data = $this->asuransi($request);
		}
		else if ($key == 'kamar_inap') {
			$data = $this->kamar_inap($request);
		}
		else if ($key == 'paket_bedah') {
			$data = $this->paket_bedah($request);
		}
		else if ($key == 'carabayar_tindakan_rawat_jalan') {
			$data = $this->carabayar_tindakan_rawat_jalan($request);
		}
		else if ($key == 'tindakan_rawat_jalan') {
			$data = $this->tindakan_rawat_jalan($request);
		}
		else if ($key == 'carabayar_tindakan_non_bedah') {
			$data = $this->carabayar_tindakan_non_bedah($request);
		}
		else if ($key == 'tindakan_non_bedah') {
			$data = $this->tindakan_non_bedah($request);
		}
		else if ($key == 'carabayar_tindakan_bedah') {
			$data = $this->carabayar_tindakan_bedah($request);
		}
		else if ($key == 'tindakan_bedah') {
			$data = $this->tindakan_bedah($request);
		}
		else if ($key == 'obat') {
			$data = $this->obat($request);
		}
		else if ($key == 'obat2') {
			$data = $this->obat2($request);
		}
		else if ($key == 'obat3') {
			$data = $this->obat3($request);
		}
		else if ($key == 'obat4') {
			$data = $this->obat($request);
		}
		else if ($key == 'ocularsinistravisus') {
			$data = $this->ocularsinistravisus($request);
		}
		else if ($key == 'oculardextravisus') {
			$data = $this->ocularsinistravisus($request);
		}
		else if ($key == 'oculardextrabcva2') {
			$data = $this->ocularsinistravisus($request);
		}
		else if ($key == 'oculardextrabcva2') {
			$data = $this->ocularsinistravisus($request);
		}
		else if ($key == 'oculardextrapinhole') {
			$data = $this->ocularsinistrapinhole($request);
		}
		else if ($key == 'oculardextrapinhole') {
			$data = $this->ocularsinistrapinhole($request);
		}
		else if ($key == 'obatgudang') {
			$data = $this->obatgudang($request);
		}
		else if ($key == 'supplier') {
			$data = $this->supplier($request);
		}
		else if ($key == 'dokter') {
			$data = $this->dokter($request);
		}
		else if ($key == 'icd_nine') {
			$data = $this->icd_nine($request);
		}
		else if ($key == 'icd_ten') {
			$data = $this->icd_ten($request);
		}
		else if ($key == 'satuan') {
			$data = $this->satuan($request);
		}
		else if ($key == 'layanan') {
			$data = $this->layanan($request);
		}
		else if ($key == 'tarif') {
			$data = $this->tarif($request);
		}
		return $data;
	}

	private function kamar_inap() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama_jenis_kamar + ' - ' + $row->nama,

							'uuid' => $row->uuid,
							'nama' => $row->nama,
							'lantai' => $row->lantai,
							'jumlah_bed' => $row->jumlah_bed,
							'jenis_kamar_uuid' => $row->jenis_kamar_uuid,
							'nama_jenis_kamar' => $row->nama_jenis_kamar
						]
					);
				}
			});
		return $collection;
		
	}

	private function paket_bedah() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama,
							'total' => $row->total,
						]
					);
				}
			});
		return $collection;
	}
	

	private function carabayar_tindakan_rawat_jalan($request) {

		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$carabayar_uuid = $request->carabayar_uuid;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama_tindakan_rawat_jalan', 'ilike', '%'.$search.'%')
			->where('carabayar_uuid', '=', $carabayar_uuid)
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama_tindakan_rawat_jalan,
							'id' => $row->id,
							'uuid' => $row->uuid,
							'carabayar_uuid' => $row->carabayar_uuid,
							'carabayar_nama' => $row->carabayar_nama,
							'tindakan_rawat_jalan_uuid' => $row->tindakan_rawat_jalan_uuid,
							'nama_tindakan_rawat_jalan' => $row->nama_tindakan_rawat_jalan,
							'harga' => $row->harga,
							'default' => $row->default,
						]
					);
				}
			});
		return $collection;
	}

	private function tindakan_rawat_jalan() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama,
						]
					);
				}
			});
		return $collection;
	}

	private function carabayar_tindakan_non_bedah() {

		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama_tindakan_rawat_jalan,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'carabayar_uuid' => $row->carabayar_uuid,
							'carabayar_nama' => $row->carabayar_nama,
							'tindakan_rawat_jalan_uuid' => $row->tindakan_rawat_jalan_uuid,
							'nama_tindakan_rawat_jalan' => $row->nama_tindakan_rawat_jalan,
							'harga' => $row->harga,
							'default' => $row->default,
						]
					);
				}
			});
		return $collection;
		
	}

	private function tindakan_non_bedah() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama,
						]
					);
				}
			});
		return $collection;
	}

	private function carabayar_tindakan_bedah() {
		return DB::table('carabayar_tindakan_bedah')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
		
		
	}

	private function tindakan_bedah() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama,
							'jenis' => $row->jenis,
						]
					);
				}
			});
		return $collection;
	}
	private function obat() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama,
							'keterangan' => $row->keterangan,
							'satuan_uuid_besar' => $row->satuan_uuid_besar,
							'nama_satuan_besar' => $row->nama_satuan_besar,
							'satuan_uuid_kecil' => $row->satuan_uuid_kecil,
							'nama_satuan_kecil' => $row->nama_satuan_kecil,
							'hitung_besar' => $row->hitung_besar,
							'hitung_kecil' => $row->hitung_kecil,
							'kategori' => $row->kategori,
							'formularium' => $row->formularium,
							'golongan' => $row->golongan,
							'jenis' => $row->jenis,
							'min_stock' => $row->min_stock
						]
					);
				}
			});
		return $collection;
	}
	private function obat2() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama,
							'keterangan' => $row->keterangan,
							'satuan_uuid_besar' => $row->satuan_uuid_besar,
							'nama_satuan_besar' => $row->nama_satuan_besar,
							'satuan_uuid_kecil' => $row->satuan_uuid_kecil,
							'nama_satuan_kecil' => $row->nama_satuan_kecil,
							'hitung_besar' => $row->hitung_besar,
							'hitung_kecil' => $row->hitung_kecil,
							'kategori' => $row->kategori,
							'formularium' => $row->formularium,
							'golongan' => $row->golongan,
							'jenis' => $row->jenis,
							'min_stock' => $row->min_stock
						]
					);
				}
			});
		return $collection;
	}
	private function obat3() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama,
							'keterangan' => $row->keterangan,
							'satuan_uuid_besar' => $row->satuan_uuid_besar,
							'nama_satuan_besar' => $row->nama_satuan_besar,
							'satuan_uuid_kecil' => $row->satuan_uuid_kecil,
							'nama_satuan_kecil' => $row->nama_satuan_kecil,
							'hitung_besar' => $row->hitung_besar,
							'hitung_kecil' => $row->hitung_kecil,
							'kategori' => $row->kategori,
							'formularium' => $row->formularium,
							'golongan' => $row->golongan,
							'jenis' => $row->jenis,
							'min_stock' => $row->min_stock
						]
					);
				}
			});
		return $collection;
	}

	private function ocularsinistravisus() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table('master_visus')
			->orderBy('id', 'asc')
			->where('nilai', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->nilai,
							'label' => $row->nilai,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nilai' => $row->nilai
						]
					);
				}
			});
		return $collection;
	}
	private function ocularsinistrapinhole() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table('master_pinhole')
			->orderBy('id', 'asc')
			->where('nilai', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->nilai,
							'label' => $row->nilai,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nilai' => $row->nilai
						]
					);
				}
			});
		return $collection;
	}
	private function obatgudang() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table('stock_opname')->where('nama_unit', '=', 'Gudang Farmasi')->where('delete_soft', '=', '1')
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'obat_id' => $row->obat_id,
							'obat_uuid' => $row->obat_uuid,
							'nama' => $row->nama,
							'kategori' => $row->kategori,
							'formularium' => $row->formularium,
							'golongan' => $row->golongan,
							'jenis' => $row->jenis,
							'keterangan' => $row->keterangan,
							'satuan_uuid_besar' => $row->satuan_uuid_besar,
							'nama_satuan_besar' => $row->nama_satuan_besar,
							'satuan_uuid_kecil' => $row->satuan_uuid_kecil,
							'nama_satuan_kecil' => $row->nama_satuan_kecil,
							'hitung_besar' => $row->hitung_besar,
							'hitung_kecil' => $row->hitung_kecil,
							'jumlah_kecil' => $row->jumlah_kecil,
							'jumlah_besar' => $row->jumlah_besar,
							'unit_id' => $row->unit_id,
							'unit_uuid' => $row->unit_uuid,
							'nama_unit' => $row->nama_unit,
						]
					);
				}
			});
		return $collection;
	}

	private function supplier() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama,
							'alamat' => $row->alamat,
							'kontak' => $row->kontak,
						]
					);
				}
			});
		return $collection;
	}

	private function dokter() {
		$collection = new Collection;
		$key = $request->key;
		$data = DB::table('biodata')->where('delete_soft', '=', '1')->where('posisi_pengguna', '=', '8808')
			->orderBy('id', 'asc')
			->where('nama_pengguna', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama_pengguna,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama_pengguna' => $row->nama_pengguna
						]
					);
				}
			});
		return $collection;
	}

	private function icd_nine() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'kode' => $row->kode,
							'nama' => $row->nama
						]
					);
				}
			});
		return $collection;
	}

	private function icd_ten() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'kode' => $row->kode,
							'nama' => $row->nama
						]
					);
				}
			});
		return $collection;
	}

	private function satuan() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama,
							'keterangan' => $row->keterangan
						]
					);
				}
			});
		return $collection;
	}
	
	private function layanan() {
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'kategori' => $row->kategori,
							'nama' => $row->nama
						]
					);
				}
			});
		return $collection;
	}

	private function tarif() {
		
		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('layanan_nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->layanan_nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'carabayar_uuid' => $row->carabayar_uuid,
							'carabayar_nama' => $row->carabayar_nama,
							'layanan_uuid' => $row->layanan_uuid,
							'layanan_kategori' => $row->layanan_kategori,
							'layanan_nama' => $row->layanan_nama,
							'harga' => $row->harga,
						]
					);
				}
			});
		return $collection;
	}

	private function carabayar($request) {

		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'kode' => $row->kode,
							'nama' => $row->nama
						]
					);
				}
			});
		return $collection;
	}
	

	private function asuransi($request) {

		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->uuid,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'carabayar_uuid' => $row->carabayar_uuid,
							'carabayar_kode' => $row->carabayar_kode,
							'carabayar_nama' => $row->carabayar_nama,
							'kode' => $row->kode,
							'nama' => $row->nama
						]
					);
				}
			});
		return $collection;
	}

	private function apotek($request) {

		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table('harga_obat')
			->join('stock_opname', 'harga_obat.obat_uuid', '=', 'stock_opname.obat_uuid')
			->orderBy('harga_obat.nama','asc')
			->where('harga_obat.delete_soft', '=', '1')
			->where('stock_opname.nama_unit', '=', 'Apotek')
			->where('harga_obat.nama', 'ilike', '%'.$search.'%')
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
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->obat_uuid,
							'label' => $row->nama,

							'harga_obat_id' => $row->harga_obat_id,
							'obat_uuid' => $row->obat_uuid,
							'nama' => $row->nama,
							'satuan_uuid_besar' => $row->satuan_uuid_besar,
							'nama_satuan_besar' => $row->nama_satuan_besar,
							'satuan_uuid_kecil' => $row->satuan_uuid_kecil,
							'nama_satuan_kecil' => $row->nama_satuan_kecil,
							'hitung_besar' => $row->hitung_besar,
							'hitung_kecil' => $row->hitung_kecil,
							'kategori' => $row->kategori,
							'formularium' => $row->formularium,
							'golongan' => $row->golongan,
							'jenis' => $row->jenis,
							'harga_netto' => $row->harga_netto,
							'harga_netto_discount' => $row->harga_netto_discount,
							'harga_netto_ppn' => $row->harga_netto_ppn,
							'hpp' => $row->hpp,
							'margin_resep' => $row->margin_resep,
							'margin_non_resep' => $row->margin_non_resep,
							'hja_resep' => $row->hja_resep,
							'hja_non_resep' => $row->hja_non_resep,
							'hja_resep_besar' => $row->hja_resep_besar,
							'hja_non_resep_besar' => $row->hja_non_resep_besar,
							'min_stock' => $row->min_stock,
							'jumlah_kecil' => $row->jumlah_kecil,
							'jumlah_besar' => $row->jumlah_besar
						]
					);
				}
			});
		return $collection;
	}

	private function kelurahan($request) {

		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->id,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama
						]
					);
				}
			});
		return $collection;
	}

	private function kecamatan($request) {

		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->id,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama
						]
					);
				}
			});
		return $collection;
	}

	private function kab_kota($request) {

		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->id,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama
						]
					);
				}
			});
		return $collection;
	}

	private function jenis_kamar($request) {

		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->id,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama
						]
					);
				}
			});
		return $collection;
	}

	private function provinsi($request) {

		$collection = new Collection;
		$key = $request->key;
		$search = $request->search;
		$data = DB::table($key)
			->orderBy('id', 'asc')
			->where('nama', 'ilike', '%'.$search.'%')
			->chunk(25, function ($data) use ($collection, $key) {
				foreach ($data as $row) {
					$collection->push(
						(object) [
							'value' => $row->id,
							'label' => $row->nama,

							'id' => $row->id,
							'uuid' => $row->uuid,
							'nama' => $row->nama
						]
					);
				}
			});
		return $collection;
	}

	

}
