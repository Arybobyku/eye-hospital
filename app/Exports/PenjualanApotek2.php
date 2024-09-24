<?php 

namespace App\Exports;
use DB;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepBebas;
use App\Models\ResepRacikan;
use App\Models\ResepRacikanBebas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;

class PenjualanApotek implements FromView, ShouldAutoSize
{
	private $dari = '';
	private $ke = '';
	private $dokter_uuid = '';
	public function __construct($dari, $ke, $dokter_uuid) {
		$this->dari = $dari;
		$this->ke = $ke;
		$this->dokter_uuid = $dokter_uuid;
	}

  public function view(): View
  {
		$data = DB::table('registrasi')
									->join('resep', 'registrasi.uuid', '=', 'resep.registrasi_uuid')
									->whereBetween('resep.tanggal', [$this->dari, $this->ke])
									->where('registrasi.status', '=', 'Selesai')
									->orderBy('resep.tanggal', 'asc');
		$data2 = DB::table('registrasi')
									->join('resepracikan', 'registrasi.uuid', '=', 'resepracikan.registrasi_uuid')
									->whereBetween('resepracikan.tanggal', [$this->dari, $this->ke])
									->where('registrasi.status', '=', 'Selesai')
									->orderBy('resepracikan.tanggal', 'asc');
								
		$data3 = array();
		$data4 = array();

		$nama_dokter = '-';
		if ($this->dokter_uuid != 'empty') {
			$tmp = DB::table('biodata')->where('uuid', '=', $this->dokter_uuid)->first();
			if ($tmp) { $nama_dokter = $tmp->nama_pengguna; }
			$data = $data->where('pengguna_uuid', '=', $this->dokter_uuid);
			$data2 = $data2->where('pengguna_uuid', '=', $this->dokter_uuid);
		}
		else {
			$data3 = DB::table('pasienbebas')
								->join('resepbebas', 'pasienbebas.uuid', '=', 'resepbebas.pasienbebas_uuid')
								->whereBetween('resepbebas.tanggal', [$this->dari, $this->ke])->get();
			$data4 = DB::table('pasienbebas')
							->join('resepracikanbebas', 'pasienbebas.uuid', '=', 'resepracikanbebas.pasienbebas_uuid')
							->whereBetween('resepracikanbebas.tanggal', [$this->dari, $this->ke])->get();
		}
		$data = $data->get();
		$data2 = $data2->get();

		$collection = new Collection;

		foreach ($data as $row) {
			$collection->push((object)[
				'jenis' => 'Resep Non Racikan',
				'tipe' => $row->jenis,
				'tanggal' => $row->tanggal,
				'waktu' => $row->waktu,
				'nama_dokter' => $row->nama_dokter,
				'nama_pasien' => $row->nama_pasien,
				'nama_obat' => $row->nama_obat,
				'jumlah_kecil' => $row->jumlah_kecil,
				'nama_satuan_kecil' => $row->nama_satuan_kecil,
				'hja_resep' => $row->hja_resep,
				'total' => $row->total
				
			]);
		}

		foreach ($data2 as $row) {
			$informasi = json_decode($row->informasi);
			foreach($informasi as $rowin) {
				$collection->push((object)[
					'jenis' => 'Resep Racikan',
					'tipe' => $row->jenis,
					'tanggal' => $row->tanggal,
					'waktu' => $row->waktu,
					'nama_dokter' => $row->nama_dokter,
					'nama_pasien' => $row->nama_pasien,
					'nama_obat' => $rowin->nama,
					'jumlah_kecil' => $rowin->jumlah_kecil,
					'nama_satuan_kecil' => $rowin->nama_satuan_kecil,
					'hja_resep' => $rowin->hja_resep,
					'total' => $rowin->total
				]);
		}

		foreach ($data3 as $row) {
			$collection->push((object)[
				'jenis' => 'Resep Non Racikan',
				'tipe' => 'Pasien Bebas',
				'tanggal' => $row->tanggal,
				'waktu' => $row->waktu,
				'nama_dokter' => '-',
				'nama_pasien' => $row->nama_pasien,
				'nama_obat' => $row->nama_obat,
				'jumlah_kecil' => $row->jumlah_kecil,
				'nama_satuan_kecil' => $row->nama_satuan_kecil,
				'hja_resep' => $row->hja_resep,
				'total' => $row->total
				
			]);
		}

		foreach ($data4 as $row) {
			$informasi = json_decode($row->informasi);
			foreach($informasi as $rowin) {
				$collection->push((object)[
					'jenis' => 'Resep Racikan',
					'tipe' => 'Pasien Bebas',
					'tanggal' => $row->tanggal,
					'waktu' => $row->waktu,
					'nama_dokter' => '-',
					'nama_pasien' => $row->nama_pasien,
					'nama_obat' => $rowin->nama,
					'jumlah_kecil' => $rowin->jumlah_kecil,
					'nama_satuan_kecil' => $rowin->nama_satuan_kecil,
					'hja_resep' => $rowin->hja_resep,
					'total' => $rowin->total
					
				]);
			}
		}

    return view('exports.penjualanapotek', [ 'data' => $collection, 'nama_dokter' => $nama_dokter, 'ke' => $this->ke, 'dari' => $this->dari ]);
  }
}
