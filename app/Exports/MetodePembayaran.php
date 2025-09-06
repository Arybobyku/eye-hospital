<?php 

namespace App\Exports;
use DB;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class MetodePembayaran implements FromView, ShouldAutoSize
{
	private $totalValue = 18;
	private $totalRow = 0;
	
	public function __construct() {
	}

	public function view(): View
	{
			set_time_limit(3000);
			$data = $this->rdata();
			
			return view('exports.metodepembayaran', ['data'=>$data]);
	}

	// public function registerEvents(): array
	// {
	// 	$tmp = $this->rdata();
	// 	$alphabetRange = range('A', 'Z');
	// 	$total = $tmp->count() + 3;
	// 	$alphabet = $alphabetRange[$total]; // returns Alphabet
    //     $cellRange = 'A1:'.$alphabet.$total;
	// 	return [
	// 		AfterSheet::class    => function(AfterSheet $event) use ($cellRange) {

	// 				$styleHeader = [
	// 					'borders' => [
	// 						'allBorders' => [
	// 							'borderStyle' => 'thin',
	// 							'color' => ['rgb' => '000000']
	// 						],
	// 					]
	// 				];
	// 				$event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleHeader);
	// 				$event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);                      
	// 		},
	// 	];
	// }

	private function rdata() {
		$data = DB::table('carabayar as cb')
			->leftJoin('carabayar_tindakan_rawat_jalan as trj', 'trj.carabayar_uuid', '=', 'cb.uuid')
			->leftJoin('carabayar_tindakan_non_bedah as tnb', 'tnb.carabayar_uuid', '=', 'cb.uuid')
			->leftJoin('carabayar_tindakan_bedah as tb', 'tb.carabayar_uuid', '=', 'cb.uuid')
			->leftJoin('carabayar_kamar as ck', 'ck.carabayar_uuid', '=', 'cb.uuid')
			->where('cb.delete_soft', 1)
			->groupBy('cb.id', 'cb.uuid', 'cb.kode', 'cb.nama', 'cb.status', 'cb.delete_soft', 'cb.created_at')
			->orderBy('cb.id', 'desc')
			->select(
				'cb.id',
				'cb.uuid',
				'cb.kode',
				'cb.nama',
				'cb.status',
				'cb.delete_soft',
				'cb.created_at',
				DB::raw("
					COALESCE(
						json_agg(
							DISTINCT jsonb_build_object(
								'id', trj.id,
								'uuid', trj.uuid,
								'carabayar_uuid', trj.carabayar_uuid,
								'carabayar_nama', cb.nama,
								'default', trj.default,
								'jenis', trj.jenis,
								'nama_tindakan_rawat_jalan', trj.nama_tindakan_rawat_jalan,
								'harga', trj.harga
							)
						) FILTER (WHERE trj.id IS NOT NULL), '[]'
					) as tindakanrawatjalan
				"),
				DB::raw("
					COALESCE(
						json_agg(
							DISTINCT jsonb_build_object(
								'id', tnb.id,
								'uuid', tnb.uuid,
								'carabayar_uuid', tnb.carabayar_uuid,
								'carabayar_nama', cb.nama,
								'nama_tindakan_non_bedah', tnb.nama_tindakan_non_bedah,
								'harga', tnb.harga
							)
						) FILTER (WHERE tnb.id IS NOT NULL), '[]'
					) as tindakannonbedah
				"),
				DB::raw("
					COALESCE(
						json_agg(
							DISTINCT jsonb_build_object(
								'id', tb.id,
								'uuid', tb.uuid,
								'carabayar_uuid', tb.carabayar_uuid,
								'carabayar_nama', cb.nama,
								'nama_tindakan_bedah', tb.nama_tindakan_bedah,
								'harga', tb.vip_harga
							)
						) FILTER (WHERE tb.id IS NOT NULL), '[]'
					) as tindakanbedah
				"),
				DB::raw("
					COALESCE(
						json_agg(
							DISTINCT jsonb_build_object(
								'id', ck.id,
								'uuid', ck.uuid,
								'carabayar_uuid', ck.carabayar_uuid,
								'carabayar_nama', cb.nama,
								'jenis', ck.jenis,
								'nama_jenis_kamar', ck.nama_jenis_kamar,
								'harga', ck.harga
							)
						) FILTER (WHERE ck.id IS NOT NULL), '[]'
					) as jeniskamar
				")
			)
			->get();

		$data = $data->map(function ($item) {
			$item->tindakanrawatjalan = json_decode($item->tindakanrawatjalan);
			$item->tindakannonbedah   = json_decode($item->tindakannonbedah);
			$item->tindakanbedah      = json_decode($item->tindakanbedah);
			$item->jeniskamar         = json_decode($item->jeniskamar);
			return $item;
		});
		return $data;
	}

}