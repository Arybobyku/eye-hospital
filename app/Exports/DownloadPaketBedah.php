<?php

namespace App\Exports;

use App\Models\CaraBayarTindakanRawatJalan;
use App\Models\ListPaketBedahBaru;
use DB;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use App\Models\TindakanRawatJalan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class DownloadPaketBedah implements FromView, ShouldAutoSize
{
	public function __construct() {}

	public function view(): View
	{
		set_time_limit(3000);
		$data = $this->rdata();
		return view('exports.templatepaketbedah', ['data' => $data]);
	}

	private function rdata()
	{
		$data = ListPaketBedahBaru::where('delete_soft', '=', 1)
			->orderBy('nama_paket_bedah', 'ASC')
			->get();
		return $data;
	}
}
