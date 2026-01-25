<?php 

namespace App\Exports;
use DB;
use App\Models\Registrasi;
use App\Models\StockOpname;
use App\Models\MintaTerimaOpname;
use App\Models\ResepRacikan;
use App\Models\Resep;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CetakKartuStock implements FromView, ShouldAutoSize
{
	private $posisi = '';
	public function __construct($posisi, $nama_obat, $dari, $ke) {
		$this->posisi = $posisi;
		$this->nama_obat = $nama_obat;
		$this->dari = $dari;
		$this->ke = $ke;
	}

  public function view(): View
  {
		$nama = '';
		$uuid = '';
		if ($this->posisi == 'kartustockall') { $uuid = 'd88a34c8-f377-4477-88bc-643a8e0e041b'; $nama = 'All Kartu Stock'; }
		else if ($this->posisi == 'gudang') { $uuid = 'bc0582ff-ce98-45f4-b361-ecef5b686a0f'; $nama = 'Gudang Farmasi'; }
		else if ($this->posisi == 'bedah') { $uuid = 'c7887937-6e20-45dd-b437-f0ee6dccc1fa'; $nama = 'Bedah Central'; }
		else if ($this->posisi == 'rawatjalan') { $uuid = '60df3cd5-57c2-4f05-b5fa-dffba34400dc'; $nama = 'Rawat Jalan'; }

		$collection = new \Collection();

		// Untuk masuk apotek
		$masuk_apotek = MintaTerimaOpname::whereDate('tanggal_terima', '>=', $this->dari)
											->whereDate('tanggal_terima', '<=', $this->ke)
											->where('unit_uuid', '=', 'd88a34c8-f377-4477-88bc-643a8e0e041b')
											->where('status', '=', 'Diterima')
											->orderBy('tanggal_terima', 'asc');
		
		if ($nama_obat != 'kosong') {
			$masuk_apotek = $masuk_apotek->where('obat_uuid', '=', $nama_obat);
		}
		$masuk_apotek->get();

		// while (strtotime($this->dari) <= strtotime($this->ke)) {
		// 	$dari = date ("Y-m-d", strtotime("+1 day", strtotime($dari)));//looping tambah 1 date	
		// }
		foreach ($masuk_apotek as $row) {
			$collection->push((object)[
				'posisi' => 'Apotek',
				'tanggal' => $row->tanggal_terima,
				'nama' => $row->nama,
				'kategori' => $row->kategori,
				'formularium' => $row->formularium,
				'golongan' => $row->golongan,
				'minta_kecil_masuk' => $row->minta_kecil,
				'nama_satuan_kecil_masuk' => $row->nama_satuan_kecil,
				'minta_kecil_keluar' => '',
				'nama_satuan_kecil_keluar' => '',
			]);
		}

		// Untuk keluar apotek
		$keluar_apotek = Resep::join('registrasi', 'resep.registrasi_uuid', '=', 'registrasi.uuid')
											->whereDate('registrasi.tanggal', '>=', $this->dari)
											->whereDate('registrasi.tanggal', '<=', $this->ke)
											->where('registrasi.status', '=', 'Selesai')
											->select('resep.*')
											->orderBy('registrasi.tanggal', 'asc');

		if ($nama_obat != 'kosong') {
			$keluar_apotek = $keluar_apotek->where('resep.obat_uuid', '=', $nama_obat);
		}
		$keluar_apotek->get();


		foreach ($masuk_apotek as $row) {
			$collection->push((object)[
				'posisi' => 'Apotek',
				'tanggal' => $row->tanggal_terima,
				'nama' => $row->nama,
				'kategori' => $row->kategori,
				'formularium' => $row->formularium,
				'golongan' => $row->golongan,
				'minta_kecil_masuk' => $row->minta_kecil,
				'nama_satuan_kecil_masuk' => $row->nama_satuan_kecil,
				'minta_kecil_keluar' => '',
				'nama_satuan_kecil_keluar' => '',
			]);
		}


											
		// Untuk masuk bedah
		$masuk_bedah = MintaTerimaOpname::whereDate('tanggal_terima', '>=', $this->dari)
											->whereDate('tanggal_terima', '<=', $this->ke)
											->where('unit_uuid', '=', 'c7887937-6e20-45dd-b437-f0ee6dccc1fa');
		
		if ($nama_obat != 'kosong') {
			$masukbedah = $masuk_bedah->where('obat_uuid', '=', $nama_obat);
		}
		$masuk_bedah->get();

		// Untuk masuk rawat jalan
		$masuk_rawatjalan = MintaTerimaOpname::whereDate('tanggal_terima', '>=', $this->dari)
											->whereDate('tanggal_terima', '<=', $this->ke)
											->where('unit_uuid', '=', '60df3cd5-57c2-4f05-b5fa-dffba34400dc');
		
		if ($nama_obat != 'kosong') {
			$masukrawatjalan = $masuk_rawatjalan->where('obat_uuid', '=', $nama_obat);
		}
		$masuk_rawatjalan->get();

    return view('exports.cetakstock', [ 'data' => $data, 'nama' => $nama ]);
  }
}