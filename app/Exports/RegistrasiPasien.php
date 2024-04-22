<?php 

namespace App\Exports;
use DB;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RegistrasiPasien implements FromView, ShouldAutoSize
{
	private $dari = '';
	private $ke = '';
	private $carabayar_uuid = '';
	private $asuransi_uuid = '';
	private $dokter_uuid = '';
	public function __construct($dari, $ke, $carabayar_uuid, $asuransi_uuid, $dokter_uuid) {
		$this->dari = $dari;
		$this->ke = $ke;
		$this->carabayar_uuid = $carabayar_uuid;
		$this->asuransi_uuid = $asuransi_uuid;
		$this->dokter_uuid = $dokter_uuid;
	}

  public function view(): View
  {
		$data = DB::table('registrasi')
									->whereBetween('tanggal', [$this->dari, $this->ke])
									->where('status', '=', 'Selesai')
									->orderBy('tanggal', 'asc')
									->select(
										'tanggal as tanggal',
										'kode as kode',
										'nomor as nomor',
										'jenis as jenis',
										'no_kwitansi as no_kwitansi',
										'nama_pasien as nama_pasien',
										'rekam_medis as rekam_medis',
										'nama_dokter as nama_dokter',
										'cara_masuk as cara_masuk',
										'carabayar_nama as carabayar_nama',
										'asuransi_uuid as asuransi_uuid',
										'nama_asuransi as nama_asuransi',
										'dokter_jam_periksa as dokter_jam_periksa',
										'kasir_jam_selesai as kasir_jam_selesai',
										'tanggal_bayar as tanggal_bayar',
										'metode_pembayaran as metode_pembayaran'
									);
		$carabayar_nama = '-';
		if ($this->carabayar_uuid != 'empty') {
			$tmp = DB::table('carabayar')->where('uuid', '=', $this->carabayar_uuid)->first();
			if ($tmp) { $carabayar_nama = $tmp->nama; }
			$data = $data->where('carabayar_uuid', '=', $this->carabayar_uuid);
		}

		$nama_asuransi = '-';
		if ($this->asuransi_uuid != 'empty') {
			$tmp = DB::table('asuransi')->where('uuid', '=', $this->asuransi_uuid)->first();
			if ($tmp) { $nama_asuransi = $tmp->nama; }
			$data = $data->where('asuransi_uuid', '=', $this->asuransi_uuid);
		}

		$nama_dokter = '-';
		if ($this->dokter_uuid != 'empty') {
			$tmp = DB::table('biodata')->where('uuid', '=', $this->dokter_uuid)->first();
			if ($tmp) { $nama_dokter = $tmp->nama_pengguna; }
			$data = $data->where('pengguna_uuid', '=', $this->dokter_uuid);
		}

		$data = $data->get();
    return view('exports.registrasipasien', [ 
			'data' => $data, 
			'carabayar_nama' => $carabayar_nama, 
			'nama_dokter' => $nama_dokter, 
			'nama_asuransi' => $nama_asuransi, 
			'ke' => $this->ke, 
			'dari' => $this->dari 
		]);
  }
}