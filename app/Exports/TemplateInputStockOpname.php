<?php

namespace App\Exports;

use App\Models\Obat;
use DB;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use App\Models\StockOpname;
use App\Models\TindakanRawatJalan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class TemplateInputStockOpname implements FromView, ShouldAutoSize
{
	private $name = '';
	private $tanggal = '';
	private $waktu = '';
	private $unit = '';

	public function __construct($name, $tanggal = '', $waktu = '', $unit = '')
	{
		$this->name = $name;
		$this->tanggal = $tanggal;
		$this->waktu = $waktu;
		$this->unit = $unit;
	}

	public function view(): View
	{
		set_time_limit(3000);
		$data = $this->rdata();

		return view('exports.templatestockopname', ['data' => $data, 'name' => $this->name, 'tanggal' => $this->tanggal, 'waktu' => $this->waktu]);
	}

	private function rdata()
	{
		$data = StockOpname::where('delete_soft', '=', '1')->where('nama_unit', '=', $this->unit)->orderBy('nama', 'asc')->get();
		return $data;
	}
}
