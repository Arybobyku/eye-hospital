<?php 

namespace App\Exports;
use DB;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReturGudang implements FromView, ShouldAutoSize
{
	private $dari = '';
	private $ke = '';
	private $supplier_uuid = '';
	public function __construct($dari, $ke, $supplier_uuid) {
		$this->dari = $dari;
		$this->ke = $ke;
		$this->supplier_uuid = $supplier_uuid;
	}

  public function view(): View
  {
		$data = DB::table('retur_obat')
									->whereBetween('tanggal_retur', [$this->dari, $this->ke])
									->orderBy('tanggal_retur', 'asc');
		$nama_supplier = '-';
		if ($this->supplier_uuid != 'empty') {
			$tmp = DB::table('supplier')->where('uuid', '=', $this->supplier_uuid)->first();
			if ($tmp) { $nama_supplier = $tmp->nama; }
			$data = $data->where('supplier_uuid', '=', $this->supplier_uuid);
		}
		$data = $data->get();
    return view('exports.returgudang', [ 'data' => $data, 'nama_supplier' => $nama_supplier, 'ke' => $this->ke, 'dari' => $this->dari ]);
  }
}