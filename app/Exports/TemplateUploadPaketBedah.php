<?php

namespace App\Exports;

use App\Models\CaraBayarTindakanRawatJalan;
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

class TemplateUploadPaketBedah implements FromView, ShouldAutoSize
{
	private $metode = '';
	private $name = '';

	public function __construct($metode, $name)
	{
		$this->metode = $metode;
		$this->name = $name;
	}

	public function view(): View
	{
		set_time_limit(3000);
		$data = $this->rdata();


		return view('exports.templateuploadpaketbedah', ['data' => $data, 'name' => $this->name]);
	}

	private function rdata()
	{
		$data = CaraBayarTindakanRawatJalan::where('delete_soft', '=', 1)
			->where("carabayar_uuid", '=', $this->metode)
			->orderBy('id', 'desc')
			->get();
		return $data;
	}
}
