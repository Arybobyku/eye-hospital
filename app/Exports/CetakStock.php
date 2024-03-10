<?php 

namespace App\Exports;
use DB;
use App\Models\Registrasi;
use App\Models\StockOpname;
use App\Models\ResepRacikan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CetakStock implements FromView, ShouldAutoSize
{
	private $posisi = '';
	public function __construct($posisi) {
		$this->posisi = $posisi;
	}

  public function view(): View
  {
		$nama = '';
		$uuid = '';
		if ($this->posisi == 'apotek') { $uuid = 'd88a34c8-f377-4477-88bc-643a8e0e041b'; $nama = 'Apotek'; }
		else if ($this->posisi == 'gudang') { $uuid = 'bc0582ff-ce98-45f4-b361-ecef5b686a0f'; $nama = 'Gudang Farmasi'; }
		else if ($this->posisi == 'bedah') { $uuid = 'c7887937-6e20-45dd-b437-f0ee6dccc1fa'; $nama = 'Bedah Central'; }
		else if ($this->posisi == 'rawatjalan') { $uuid = '60df3cd5-57c2-4f05-b5fa-dffba34400dc'; $nama = 'Rawat Jalan'; }

		$data = StockOpname::where('delete_soft', '=', 1)
									->orderBy('nama', 'asc')
									->where('unit_uuid', '=', $uuid)
									->get();
    return view('exports.cetakstock', [ 'data' => $data, 'nama' => $nama ]);
  }
}