<?php

namespace App\Exports;

use DB;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KontrolPasien implements FromView, ShouldAutoSize
{
	private $dari = '';
	private $ke = '';
	private $carabayar_uuid = '';
	private $asuransi_uuid = '';
	private $dokter_uuid = '';

	public function __construct($dari, $ke, $carabayar_uuid = 'empty', $asuransi_uuid = 'empty', $dokter_uuid = 'empty')
	{
		$this->dari = $dari;
		$this->ke = $ke;
		$this->carabayar_uuid = $carabayar_uuid;
		$this->asuransi_uuid = $asuransi_uuid;
		$this->dokter_uuid = $dokter_uuid;
	}

	public function view(): View
	{
		// Base query (mengikuti style contohmu)
		$q = DB::table('registrasi as r')
			->leftJoin('pasien as p', 'p.uuid', '=', 'r.uuid') // NOTE: sesuaikan jika key-nya beda
			->leftJoin('pemeriksaan_dokter as pd', 'pd.registrasi_uuid', '=', 'r.uuid')
			->leftJoin('registrasi_operasi as ro', 'ro.registrasi_uuid', '=', 'r.uuid')
			->whereBetween('r.tanggal', [$this->dari, $this->ke])
			->where('r.status', '=', 'Selesai')
			->where(function ($w) {
				$w->whereNotNull('pd.tanggal_kontrol_selanjutnya')
					->orWhere('r.apakah_bedah', '=', 'Ya');
			})
			->orderBy('r.tanggal', 'asc')
			->select([
				'r.nama_pasien as nama_pasien',
				'r.rekam_medis as rekam_medis',
				'r.tanggal_lahir as tanggal_lahir',
				'p.no_handphone as no_handphone',
				'r.nama_dokter as nama_dokter',
				'r.metode_pembayaran as metode_pembayaran',
				'pd.anamnese as anamnese', // kamu bisa rename jadi diagnosa
				'pd.pemeriksaan_prognosa as pemeriksaan_prognosa',
				'pd.tanggal_kontrol_selanjutnya as tanggal_kontrol_selanjutnya',
				'ro.tanggal as jadwal_operasi',
				'ro.nama_layanan as paket_bedah',
			]);

		// Optional filter seperti contohmu
		$carabayar_nama = '-';
		if ($this->carabayar_uuid !== 'empty') {
			$tmp = DB::table('carabayar')->where('uuid', '=', $this->carabayar_uuid)->first();
			if ($tmp) {
				$carabayar_nama = $tmp->nama;
			}
			$q = $q->where('r.carabayar_uuid', '=', $this->carabayar_uuid);
		}

		$nama_asuransi = '-';
		if ($this->asuransi_uuid !== 'empty') {
			$tmp = DB::table('asuransi')->where('uuid', '=', $this->asuransi_uuid)->first();
			if ($tmp) {
				$nama_asuransi = $tmp->nama;
			}
			$q = $q->where('r.asuransi_uuid', '=', $this->asuransi_uuid);
		}

		$nama_dokter = '-';
		if ($this->dokter_uuid !== 'empty') {
			$tmp = DB::table('biodata')->where('uuid', '=', $this->dokter_uuid)->first();
			if ($tmp) {
				$nama_dokter = $tmp->nama_pengguna;
			}
			$q = $q->where('r.pengguna_uuid', '=', $this->dokter_uuid);
		}

		$data = $q->get();

		return view('exports.kontrolPasien', [
			'data' => $data,
			'dari' => $this->dari,
			'ke' => $this->ke,
			'carabayar_nama' => $carabayar_nama,
			'nama_asuransi' => $nama_asuransi,
			'nama_dokter' => $nama_dokter,
		]);
	}
}
