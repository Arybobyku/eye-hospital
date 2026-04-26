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

class TindakanPasienV2 implements FromView, ShouldAutoSize, WithEvents
{
	private $totalValue = 18;
	private $totalRow = 0;
	private $dari = '';
	private $ke = '';
	private $carabayar_uuid = '';
	private $asuransi_uuid = '';
	private $dokter_uuid = '';
	private $jenis_registrasi = '';
	private $layanan_uuid = '';

	public function __construct($dari, $ke, $carabayar_uuid, $asuransi_uuid, $dokter_uuid, $layanan_uuid, $jenis_registrasi) {
		$this->dari = $dari;
		$this->ke = $ke;
		$this->carabayar_uuid = $carabayar_uuid;
		$this->asuransi_uuid = $asuransi_uuid;
		$this->dokter_uuid = $dokter_uuid;
		$this->layanan_uuid = $layanan_uuid;
		$this->jenis_registrasi = $jenis_registrasi;
	}

  public function view(): View
  {
		set_time_limit(3000);
		$tmp = $this->rdata();
		
    return view('exports.tindakanpasienv2', [ 
			'data' => $tmp['data'], 
			'carabayar_nama' => $tmp['carabayar_nama'], 
			'nama_dokter' => $tmp['nama_dokter'], 
			'nama_asuransi' => $tmp['nama_asuransi'], 
			'nama_layanan' => $tmp['nama_layanan'], 
			'ke' => $this->ke, 
			'dari' => $this->dari 
		]);
  }

	public function registerEvents(): array
	{
		$alphabetRange = range('A', 'Z');
		$alphabet = $alphabetRange[18]; // returns Alphabet
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

	private function rdata() {
		$layanan = DB::table('layanan_pasien')
									->join('registrasi', 'layanan_pasien.registrasi_uuid', '=', 'registrasi.uuid')
									// ->join('resep', 'layanan_pasien.registrasi_uuid', '=', 'resep.registrasi_uuid')
									->whereBetween('registrasi.tanggal', [$this->dari, $this->ke])
									->where('registrasi.status', '=', 'Selesai')
									->where('layanan_pasien.layanan_uuid', '!=', 'obatan')
									->where('layanan_pasien.layanan_uuid', '!=', 'obatracikan')
									->where('layanan_pasien.layanan_uuid', '!=', 'obatanbedah')
									->where('layanan_pasien.layanan_uuid', '!=', 'obatracikanbedah')
									->orderBy('registrasi.nomor', 'asc')
									->select(
										'registrasi.tanggal as tanggal',
										'registrasi.kode as kode',
										'registrasi.nomor as nomor',
										'registrasi.jenis as jenis',
										'registrasi.no_kwitansi as no_kwitansi',
										'registrasi.nama_pasien as nama_pasien',
										'registrasi.rekam_medis as rekam_medis',
										'registrasi.nama_dokter as nama_dokter',
										'registrasi.cara_masuk as cara_masuk',
										'registrasi.carabayar_nama as carabayar_nama',
										'registrasi.asuransi_uuid as asuransi_uuid',
										'registrasi.nama_asuransi as nama_asuransi',
										'registrasi.dokter_jam_periksa as dokter_jam_periksa',
										'registrasi.kasir_jam_selesai as kasir_jam_selesai',
										'registrasi.tanggal_bayar as tanggal_bayar',
										'registrasi.metode_pembayaran as metode_pembayaran',
										'registrasi.diskon_rp as registrasi_diskon_rp',
										'registrasi.diskon_persen as registrasi_diskon_persen',

										'layanan_pasien.nama_layanan as nama_layanan',
										'layanan_pasien.tarif as tarif',
										'layanan_pasien.diskon_rp as diskon_rp',
										'layanan_pasien.diskon_persen as diskon_persen',
										'layanan_pasien.total as total',
										DB::raw("'Tindakan' as tipe"),
									);

		$obat = DB::table('resep')
				->join('registrasi', 'resep.registrasi_uuid', '=', 'registrasi.uuid')
			    ->leftJoin('layanan_pasien', function ($join) {
					$join->on('layanan_pasien.registrasi_uuid', '=', 'registrasi.uuid')
						->where('layanan_pasien.layanan_uuid', '=', 'obatan');
				})
				->whereBetween('registrasi.tanggal', [$this->dari, $this->ke])
				->where('registrasi.status', 'Selesai')
				->where('layanan_pasien.layanan_uuid', 'obatan')
				->select(
						'registrasi.tanggal as tanggal',
						'registrasi.kode as kode',
						'registrasi.nomor as nomor',
						'registrasi.jenis as jenis',
						'registrasi.no_kwitansi as no_kwitansi',
						'registrasi.nama_pasien as nama_pasien',
						'registrasi.rekam_medis as rekam_medis',
						'registrasi.nama_dokter as nama_dokter',
						'registrasi.cara_masuk as cara_masuk',
						'registrasi.carabayar_nama as carabayar_nama',
						'registrasi.asuransi_uuid as asuransi_uuid',
						'registrasi.nama_asuransi as nama_asuransi',
						'registrasi.dokter_jam_periksa as dokter_jam_periksa',
						'registrasi.kasir_jam_selesai as kasir_jam_selesai',
						'registrasi.tanggal_bayar as tanggal_bayar',
						'registrasi.metode_pembayaran as metode_pembayaran',
						'registrasi.diskon_rp as registrasi_diskon_rp',
						'registrasi.diskon_persen as registrasi_diskon_persen',

						'resep.nama_obat as nama_layanan',
						'resep.total as tarif',
						'layanan_pasien.diskon_rp as diskon_rp',
						'layanan_pasien.diskon_persen as diskon_persen',
						DB::raw('
							resep.total
							- (resep.total * COALESCE(layanan_pasien.diskon_persen, 0) / 100)
							AS total
							'),
						DB::raw("'Obat' as tipe"),
				);

		$obatBedah = DB::table('resep')
				->join('registrasi', 'resep.registrasi_uuid', '=', 'registrasi.uuid')
			    ->leftJoin('layanan_pasien', function ($join) {
					$join->on('layanan_pasien.registrasi_uuid', '=', 'registrasi.uuid')
						->where('layanan_pasien.layanan_uuid', '=', 'obatanbedah');
				})
				->whereBetween('registrasi.tanggal', [$this->dari, $this->ke])
				->where('registrasi.status', 'Selesai')
				->where('layanan_pasien.layanan_uuid', 'obatanbedah')
				->select(
						'registrasi.tanggal as tanggal',
						'registrasi.kode as kode',
						'registrasi.nomor as nomor',
						'registrasi.jenis as jenis',
						'registrasi.no_kwitansi as no_kwitansi',
						'registrasi.nama_pasien as nama_pasien',
						'registrasi.rekam_medis as rekam_medis',
						'registrasi.nama_dokter as nama_dokter',
						'registrasi.cara_masuk as cara_masuk',
						'registrasi.carabayar_nama as carabayar_nama',
						'registrasi.asuransi_uuid as asuransi_uuid',
						'registrasi.nama_asuransi as nama_asuransi',
						'registrasi.dokter_jam_periksa as dokter_jam_periksa',
						'registrasi.kasir_jam_selesai as kasir_jam_selesai',
						'registrasi.tanggal_bayar as tanggal_bayar',
						'registrasi.metode_pembayaran as metode_pembayaran',
						'registrasi.diskon_rp as registrasi_diskon_rp',
						'registrasi.diskon_persen as registrasi_diskon_persen',

						'resep.nama_obat as nama_layanan',
						'resep.total as tarif',
						'layanan_pasien.diskon_rp as diskon_rp',
						'layanan_pasien.diskon_persen as diskon_persen',
						DB::raw('
							resep.total
							- (resep.total * COALESCE(layanan_pasien.diskon_persen, 0) / 100)
							AS total
							'),
						DB::raw("'Obat Bedah' as tipe"),
				);

		$obatRacikan = DB::table('resepracikan')
				->join('registrasi', 'resepracikan.registrasi_uuid', '=', 'registrasi.uuid')
			    ->leftJoin('layanan_pasien', function ($join) {
					$join->on('layanan_pasien.registrasi_uuid', '=', 'registrasi.uuid')
						->where('layanan_pasien.layanan_uuid', '=', 'obatracikan');
				})
				->whereBetween('registrasi.tanggal', [$this->dari, $this->ke])
				->where('registrasi.status', 'Selesai')
				->where('layanan_pasien.layanan_uuid', 'obatracikan')
				->select(
						'registrasi.tanggal as tanggal',
						'registrasi.kode as kode',
						'registrasi.nomor as nomor',
						'registrasi.jenis as jenis',
						'registrasi.no_kwitansi as no_kwitansi',
						'registrasi.nama_pasien as nama_pasien',
						'registrasi.rekam_medis as rekam_medis',
						'registrasi.nama_dokter as nama_dokter',
						'registrasi.cara_masuk as cara_masuk',
						'registrasi.carabayar_nama as carabayar_nama',
						'registrasi.asuransi_uuid as asuransi_uuid',
						'registrasi.nama_asuransi as nama_asuransi',
						'registrasi.dokter_jam_periksa as dokter_jam_periksa',
						'registrasi.kasir_jam_selesai as kasir_jam_selesai',
						'registrasi.tanggal_bayar as tanggal_bayar',
						'registrasi.metode_pembayaran as metode_pembayaran',
						'registrasi.diskon_rp as registrasi_diskon_rp',
						'registrasi.diskon_persen as registrasi_diskon_persen',

						'resepracikan.label as nama_layanan',
						'resepracikan.total as tarif',
						'layanan_pasien.diskon_rp as diskon_rp',
						'layanan_pasien.diskon_persen as diskon_persen',
						
						DB::raw('
							resepracikan.total
							- (resepracikan.total * COALESCE(layanan_pasien.diskon_persen, 0) / 100)
							AS total
							'),
						DB::raw("'Obat Racikan' as tipe"),
				);

		$obatRacikanBedah = DB::table('resepracikan')
				->join('registrasi', 'resepracikan.registrasi_uuid', '=', 'registrasi.uuid')
			    ->leftJoin('layanan_pasien', function ($join) {
					$join->on('layanan_pasien.registrasi_uuid', '=', 'registrasi.uuid')
						->where('layanan_pasien.layanan_uuid', '=', 'obatracikanbedah');
				})
				->whereBetween('registrasi.tanggal', [$this->dari, $this->ke])
				->where('registrasi.status', 'Selesai')
				->where('layanan_pasien.layanan_uuid', 'obatracikanbedah')
				->select(
						'registrasi.tanggal as tanggal',
						'registrasi.kode as kode',
						'registrasi.nomor as nomor',
						'registrasi.jenis as jenis',
						'registrasi.no_kwitansi as no_kwitansi',
						'registrasi.nama_pasien as nama_pasien',
						'registrasi.rekam_medis as rekam_medis',
						'registrasi.nama_dokter as nama_dokter',
						'registrasi.cara_masuk as cara_masuk',
						'registrasi.carabayar_nama as carabayar_nama',
						'registrasi.asuransi_uuid as asuransi_uuid',
						'registrasi.nama_asuransi as nama_asuransi',
						'registrasi.dokter_jam_periksa as dokter_jam_periksa',
						'registrasi.kasir_jam_selesai as kasir_jam_selesai',
						'registrasi.tanggal_bayar as tanggal_bayar',
						'registrasi.metode_pembayaran as metode_pembayaran',
						'registrasi.diskon_rp as registrasi_diskon_rp',
						'registrasi.diskon_persen as registrasi_diskon_persen',

						'resepracikan.label as nama_layanan',
						'resepracikan.total as tarif',
						'layanan_pasien.diskon_rp as diskon_rp',
						'layanan_pasien.diskon_persen as diskon_persen',

						DB::raw('
							resepracikan.total
							- (resepracikan.total * COALESCE(layanan_pasien.diskon_persen, 0) / 100)
							AS total
							'),
						DB::raw("'Obat Racikan Bedah' as tipe"),
				);
							
		$carabayar_nama = '-';
		if ($this->carabayar_uuid != 'empty') {
			$tmp = DB::table('carabayar')->where('uuid', '=', $this->carabayar_uuid)->first();
			if ($tmp) { $carabayar_nama = $tmp->nama; }
			$layanan = $layanan->where('registrasi.carabayar_uuid', '=', $this->carabayar_uuid);

			$obat = $obat->where('registrasi.carabayar_uuid', '=', $this->carabayar_uuid);
			$obatBedah = $obatBedah->where('registrasi.carabayar_uuid', '=', $this->carabayar_uuid);
			$obatRacikan = $obatRacikan->where('registrasi.carabayar_uuid', '=', $this->carabayar_uuid);
			$obatRacikanBedah = $obatRacikanBedah->where('registrasi.carabayar_uuid', '=', $this->carabayar_uuid);
		}

		$nama_asuransi = '-';
		if ($this->asuransi_uuid != 'empty') {
			$tmp = DB::table('asuransi')->where('uuid', '=', $this->asuransi_uuid)->first();
			if ($tmp) { $nama_asuransi = $tmp->nama; }
			$layanan = $layanan->where('registrasi.asuransi_uuid', '=', $this->asuransi_uuid);

			$obat = $obat->where('registrasi.asuransi_uuid', '=', $this->asuransi_uuid);
			$obatBedah = $obatBedah->where('registrasi.asuransi_uuid', '=', $this->asuransi_uuid);
			$obatRacikan = $obatRacikan->where('registrasi.asuransi_uuid', '=', $this->asuransi_uuid);
			$obatRacikanBedah = $obatRacikanBedah->where('registrasi.asuransi_uuid', '=', $this->asuransi_uuid);
		}

		$nama_dokter = '-';
		if ($this->dokter_uuid != 'empty') {
			$tmp = DB::table('biodata')->where('uuid', '=', $this->dokter_uuid)->first();
			if ($tmp) { $nama_dokter = $tmp->nama_pengguna; }
			$layanan = $layanan->where('registrasi.pengguna_uuid', '=', $this->dokter_uuid);

			$obat = $obat->where('registrasi.pengguna_uuid', '=', $this->dokter_uuid);
			$obatBedah = $obatBedah->where('registrasi.pengguna_uuid', '=', $this->dokter_uuid);
			$obatRacikan = $obatRacikan->where('registrasi.pengguna_uuid', '=', $this->dokter_uuid);
			$obatRacikanBedah = $obatRacikanBedah->where('registrasi.pengguna_uuid', '=', $this->dokter_uuid);
		}

		$nama_layanan = '-';
		if ($this->layanan_uuid != 'empty') {
			$tmp = DB::table('tindakan_rawat_jalan')->where('uuid', '=', $this->layanan_uuid)->first();
			if ($tmp) { $nama_layanan = $tmp->nama; }
			$layanan = $layanan->where('layanan_pasien.layanan_uuid', '=', $this->layanan_uuid);

			$obat = $obat->where('registrasi.layanan_uuid', '=', $this->layanan_uuid);
			$obatBedah = $obatBedah->where('registrasi.layanan_uuid', '=', $this->layanan_uuid);
			$obatRacikan = $obatRacikan->where('registrasi.layanan_uuid', '=', $this->layanan_uuid);
			$obatRacikanBedah = $obatRacikanBedah->where('registrasi.layanan_uuid', '=', $this->layanan_uuid);
		}

		if ($this->jenis_registrasi != 'semua') {
			$layanan = $layanan->where('registrasi.jenis', '=', $this->jenis_registrasi);

			$obat = $obat->where('registrasi.jenis', '=', $this->jenis_registrasi);
			$obatBedah = $obatBedah->where('registrasi.jenis', '=', $this->jenis_registrasi);
			$obatRacikan = $obatRacikan->where('registrasi.jenis', '=', $this->jenis_registrasi);
			$obatRacikanBedah = $obatRacikanBedah->where('registrasi.jenis', '=', $this->jenis_registrasi);
		}


		$data = $layanan
				->unionAll($obat)
				->unionAll($obatRacikan)
				->unionAll($obatBedah)
				->unionAll($obatRacikanBedah)
				->orderBy('tanggal')
				->get();

		$arr = array (
			'data' => $data,
			'carabayar_nama' => $carabayar_nama,
			'nama_asuransi' => $nama_asuransi,
			'nama_dokter' => $nama_dokter,
			'nama_layanan' => $nama_layanan,
		);

		return $arr;
	}

}