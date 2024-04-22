<?php 

namespace App\Exports;
use DB;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StockOpnameApotek implements FromView, ShouldAutoSize
{
	private $dari = '';
	public function __construct($dari) {
		$this->dari = $dari;
	}

  public function view(): View
  {
		$tgl = explode('-', $this->dari);
		$bulan = $tgl[1];
		$tahun = $tgl[0];
		$data = DB::table('stock_catat')
									->join('harga_obat', 'stock_catat.obat_uuid', '=', 'harga_obat.obat_uuid')
									->whereMonth('stock_catat.created_at', $bulan)
									->whereYear('stock_catat.created_at', $tahun)
									->where('stock_catat.unit_uuid', '=', 'd88a34c8-f377-4477-88bc-643a8e0e041b')
									->orderBy('stock_catat.created_at', 'asc')
									->select('stock_catat.*', 'harga_obat.harga_netto as harga_netto', 'harga_obat.hpp as hpp')
									->get();
		$nama_bulan = '';
		if ($bulan == '01') { $nama_bulan = 'Januari'; }
		else if ($bulan == '02') { $nama_bulan = 'Februari'; }
		else if ($bulan == '03') { $nama_bulan = 'Maret'; }
		else if ($bulan == '04') { $nama_bulan = 'April'; }
		else if ($bulan == '05') { $nama_bulan = 'Mei'; }
		else if ($bulan == '06') { $nama_bulan = 'Juni'; }
		else if ($bulan == '07') { $nama_bulan = 'Juli'; }
		else if ($bulan == '08') { $nama_bulan = 'Agustus'; }
		else if ($bulan == '09') { $nama_bulan = 'September'; }
		else if ($bulan == '10') { $nama_bulan = 'Oktober'; }
		else if ($bulan == '11') { $nama_bulan = 'November'; }
		else if ($bulan == '12') { $nama_bulan = 'Desember'; }
    return view('exports.stockopnameapotek', [ 'data' => $data, 'bulan' => $nama_bulan, 'tahun' => $tahun  ]);
  }
}