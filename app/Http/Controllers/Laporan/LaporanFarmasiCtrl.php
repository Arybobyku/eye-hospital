<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Exports\PenjualanApotek;
use App\Exports\FakturGudang;
use App\Exports\ReturGudang;
use App\Exports\StockOpnameApotek;
use App\Exports\StockOpnameGudang;
use App\Exports\KartuStockGudang;
use App\Exports\KartuStockApotek;
use App\Exports\KartuStockBedah;
use App\Models\LogPengguna;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;

class LaporanFarmasiCtrl extends Controller
{

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function penjualanapotek($dari, $ke, $dokter_uuid) {
		$filename = date('Y-m-d').'-Penjualan Apotek.xlsx';
		return \Excel::download(new PenjualanApotek($dari, $ke, $dokter_uuid), $filename);
	}

	public function fakturgudang($dari, $ke, $supplier_uuid) {
		$filename = date('Y-m-d').'-Faktur Gudang.xlsx';
		return \Excel::download(new FakturGudang($dari, $ke, $supplier_uuid), $filename);
	}

	public function stockopnameapotek($dari) {
		$filename = date('Y-m-d').'- Stock Opanme Apotek.xlsx';
		return \Excel::download(new StockOpnameApotek($dari), $filename);
	}

	public function stockopnamegudang($dari) {
		$filename = date('Y-m-d').'- Stock Opanme Gudang.xlsx';
		return \Excel::download(new StockOpnameApotek($dari), $filename);
	}

	public function returgudang($dari, $ke, $supplier_uuid) {
		$filename = date('Y-m-d').'-Retur Obat-Alkes Gudang.xlsx';
		return \Excel::download(new ReturGudang($dari, $ke, $supplier_uuid), $filename);
	}
	public function kartustockgudang($dari, $ke, $obat_uuid) {
		$filename = date('Y-m-d').'-Kartu Stock Gudang.xlsx';
		return \Excel::download(new KartuStockGudang($dari, $ke, $obat_uuid), $filename);
	}
	public function kartustockapotek($dari, $ke, $obat_uuid) {
		$filename = date('Y-m-d').'-Kartu Stock Apotek.xlsx';
		return \Excel::download(new KartuStockApotek($dari, $ke, $obat_uuid), $filename);
	}
	public function kartustockbedah($dari, $ke, $obat_uuid) {
		$filename = date('Y-m-d').'-Kartu Stock Bedah.xlsx';
		return \Excel::download(new KartuStockBedah($dari, $ke, $obat_uuid), $filename);
	}


}