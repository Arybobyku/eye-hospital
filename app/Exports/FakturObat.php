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

class FakturObat implements FromView, ShouldAutoSize, WithEvents
{
	private $dari = '';
	private $ke = '';
	public function __construct($dari) {
		$this->dari = $dari;
	}

	public function registerEvents(): array
	{
		$alphabetRange = range('A', 'Z');
		$alphabet = $alphabetRange[7]; // returns Alphabet
		$tmp = $this->rdata();
		$total = count($tmp['data']) + 3;
    $cellRange = 'A1:'.$alphabet.$total;
		return [
			AfterSheet::class    => function(AfterSheet $event) use ($cellRange) {

					$styleHeader = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => 'thin',
								'color' => ['rgb' => '000000']
							],
						]
					];
					$event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleHeader);
					$event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);                      
			},
		];
	}

  public function view(): View
  {
		// $data = DB::table('pembelian_detail')
		// 						->select([
		// 							'nama_supplier',
		// 							'no_faktur',
		// 							DB::raw("count(no_faktur) as jumlah"),
		// 							DB::raw("sum(jumlah_kecil * harga_kecil) as total"),
		// 							'penerima'
		// 						])
		// 						->groupBy([
		// 							'nama_supplier',
		// 							'no_faktur',
		// 							'penerima'
		// 						])
		// 						->whereDate('tanggal_faktur', '=', $this->dari)
		// 						->get();
		$tmp = $this->rdata();
		
    return view('exports.fakturobat', [ 'data' => $tmp['data'], 'dari' => $this->dari ]);
  }

	private function rdata() {
		$data = DB::table('pembelian')
								->leftjoin('pembelian_detail', 'pembelian.no_faktur', '=', 'pembelian_detail.no_faktur')
								->select(
									'pembelian.uuid as uuid',
									'pembelian.no_faktur as no_faktur',
									'pembelian.tanggal_faktur as tanggal_faktur',
									'pembelian.nama_supplier as nama_supplier',
									'pembelian.ppn as ppn',
									'pembelian.pembayaran as pembayaran',
									'pembelian.status_pembayaran as status_pembayaran',
									'pembelian.status as status',
									'pembelian.tempo as tempo',
									'pembelian.jangka_waktu as jangka_waktu',
									DB::raw("count(pembelian_detail.no_faktur) as jumlah"),
									DB::raw("sum(pembelian_detail.jumlah_kecil * pembelian_detail.harga_kecil) as total"),
									'pembelian_detail.penerima as penerima'
								)
									->groupBy([
										'pembelian.uuid', 
										'pembelian.no_faktur', 
										'pembelian.tanggal_faktur',
										'pembelian.nama_supplier',
										'pembelian.ppn',
										'pembelian.pembayaran',
										'pembelian.status_pembayaran',
										'pembelian.status',
										'pembelian.tempo',
										'pembelian.jangka_waktu',
										'pembelian_detail.penerima'
									])
								->orderBy('pembelian.tanggal_faktur', 'desc')
								->where('pembelian.pembayaran', '=', 'Kredit')
								->where('pembelian.status', '=', 'approve')
								->whereDate('pembelian.from_tempo', '>=', date('Y-m-d'))
								->where('pembelian.status_pembayaran', '=', 'Belum Dibayar')
								->get();
		$arr = array ('data' => $data);
		return $arr;
	}
}