<?php

namespace App\Exports;

use App\Models\BukuTarif;
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

class TemplateUploadPembayaran implements FromView, ShouldAutoSize
{
	private $metode = '';

	public function __construct($metode)
	{
		$this->metode = $metode;
	}

	public function view(): View
	{
		set_time_limit(3000);
		$data = $this->rdata();

		return view('exports.templateuploadmetodepembayaran', ['data' => $data, 'metode' => $this->metode]);
	}

	private function rdata()
	{
		$data = BukuTarif::where('delete_soft', '=', 1)
			->orderBy('label', 'ASC')
			->get();
		return $data;
	}
}
