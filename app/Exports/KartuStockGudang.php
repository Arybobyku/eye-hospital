<?php 

namespace App\Exports;
use DB;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KartuStockGudang implements FromView, ShouldAutoSize
{

	public function __construct($dari, $ke, $obatuuid) {
		$this->dari = $dari;
		$this->ke = $ke;
		$this->obatuuid = $obatuuid;
	}

  public function view(): View
  {
		// $data = DB::table('minta_terima_opname')
		// 							->where('minta_terima_opname.ke_unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
		// 							->orWhere('minta_terima_opname.dari_unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
		// 							->orderBy('minta_terima_opname.created_at', 'asc')
		// 							->get();
		if ($this->dari == 'empty') {
			$this->dari = '2000-01-01';
		}
		if ($this->ke == 'empty') {
			$this->ke = '9999-12-31';
		}
		$tgl = explode('-', $this->dari);
		$bulan = $tgl[1];
		$tahun = $tgl[0];
		$dataKeluar = DB::table('minta_terima_opname')
		->select(
			'kode',
			'nama',
			'dari_nama_unit',
			'ke_nama_unit',
			'pengirim_pengguna_nama',
			DB::raw("0 as masuk_kecil"),
			'jumlah_kecil',
			'minta_kecil',
			'created_at',
			DB::raw("'keluar' as jenis_transaksi")
		)
		->when($this->obatuuid !== 'empty', function($query) {
			return $query->where('obat_uuid', '=', $this->obatuuid);
		})
		->where(function($query) {
			$query->where('ke_unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
				  ->orWhere('dari_unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f');
		})
		->where('delete_soft', 1)

		->whereBetween('created_at', [$this->dari, $this->ke]);
	
	$allTransactions = DB::table('pembelian_detail')
		->select(
			DB::raw("no_faktur as kode"),
			'nama',
			DB::raw("'Gudang Farmasi' as ke_nama_unit"),
			DB::raw("'Pembelian' as dari_nama_unit"),
			DB::raw("penerima as pengirim_pengguna_nama"),
			DB::raw("jumlah_kecil as masuk_kecil"),
			DB::raw("0 as jumlah_kecil"),
			DB::raw("0 as minta_kecil"),
			'created_at',
			DB::raw("'masuk' as jenis_transaksi")
		)
		->when($this->obatuuid !== 'empty', function($query) {
			return $query->where('obat_uuid', '=', $this->obatuuid);
		})
		->whereBetween('created_at', [$this->dari, $this->ke])
		->where('delete_soft', 1)
		->union($dataKeluar)
		->orderBy('created_at', 'asc')
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
    return view('exports.kartustockgudang', [ 'data' => $allTransactions, 'dari' => $this->dari, 'ke' => $this->ke  ]);
  }
}