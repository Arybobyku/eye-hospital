<?php

namespace App\Http\Controllers\Master;

use App\Exports\RekamMedisExport;
use App\Models\Icd10;
use App\Models\PemeriksaanDokter;
use Maatwebsite\Excel\Facades\Excel;
use PenggunaHelp;

use App\Http\Controllers\Controller;
use App\Models\Registrasi;
use Illuminate\Http\Request;

class RekamMedisCtrl extends Controller
{
    private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

    private function generateListQuery(Request $request){
        $query = Registrasi::select([
                'registrasi.tanggal', 'registrasi.no_pendaftaran', 'registrasi.rekam_medis', 'registrasi.nama_pasien',
                \DB::raw("CASE WHEN pemeriksaan_dokter.pemeriksaan_diagnosa = 'Silahkan Pilih' THEN NULL ELSE pemeriksaan_dokter.pemeriksaan_diagnosa END as pemeriksaan_diagnosa"), 
                'registrasi.jenis_kelamin', 'pasien.kelompok_umur_nama', 'registrasi.agama', 'pasien.status_pernikahan', 'pasien.pekerjaan', 'pasien.alamat',
                'pasien.nama_kecamatan', 'pasien.nama_kab_kota', 'registrasi.cara_masuk', 
                'registrasi.jalur_masuk', \DB::raw('penanggung_jawab.nama as nama_pj'), 'registrasi.rujukan', 'p_ro.kasus_urgent',
                'registrasi.carabayar_nama', 'registrasi.ruang_poliklinik', 'registrasi.nama_dokter',
                \DB::raw("CASE WHEN registrasi.tanggal <= registrasi.tanggal_bayar THEN registrasi.tanggal_bayar ELSE NULL END as tanggal_bayar"), 
                'registrasi.status',
            ])
            // TODO: Cek apakah pemeriksaan dokter dapat terjadi lebih dari sekali untuk satu registrasi.
            ->leftJoin('pemeriksaan_dokter', 'pemeriksaan_dokter.registrasi_uuid', '=', 'registrasi.uuid')
            ->leftJoin('pasien', 'registrasi.pasien_uuid', '=', 'pasien.uuid')
            // Entah kenapa, pemeriksaan_ro dapat diinput lebih dari sekali untuk satu registrasi
            ->leftJoinSub(
                fn($q) => $q->from('pemeriksaan_ro')->select(['registrasi_uuid', 'kasus_urgent'])
                    ->selectRaw('RANK() OVER (PARTITION BY pasien_uuid ORDER BY created_at DESC) as urutan')
                , 'p_ro', fn($q) => $q->on('p_ro.registrasi_uuid', '=', 'registrasi.uuid')->where('p_ro.urutan', '=', 1)
            )
            ->leftJoin('penanggung_jawab', 'penanggung_jawab.registrasi_uuid', '=', 'registrasi.uuid')
            ->where('registrasi.delete_soft', 1)
            ->where('registrasi.rekam_medis', '!=', 'AP020739');

        if ($request->dateRange) {
            $query->where('registrasi.tanggal', '>=', $request->dateRange['start'])
                ->where('registrasi.tanggal', '<=', $request->dateRange['end']);
        }

        if ($request->jenis_kelamin) {
            $query->where('registrasi.jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->is_surgery) {
            $query->where('registrasi.apakah_paket', 'Ya');
        }

        if ($request->icd10) {
            $query->where('pemeriksaan_dokter.pemeriksaan_diagnosa_kode', $request->icd10);
        }

        if ($request->asuransi) {
            $query->where('registrasi.asuransi_uuid', $request->asuransi);
        }

        if ($request->carabayar) {
            $query->where('registrasi.carabayar_uuid', $request->carabayar);
        }

        return $query;
    }

    public function list(Request $request) {
		PenggunaHelp::log('Melihat data list table pada halaman data master rekam medis');
        
        $data = $this->generateListQuery($request)->paginate(15);

        return response()->json($data);
    }

    public function listexcel(Request $request) {
		PenggunaHelp::log('Mengunduh Excel data list table pada halaman data master rekam medis');

        $data = $this->generateListQuery($request)->get();

        return Excel::download(new RekamMedisExport($data), 'Data Rekam Medis.xlsx');
    }

    public function statsjumlahpengunjung(Request $request){
        /**
         * 1. Pasien lama harus memiliki lebih dari satu record registrasi.
         * 2. Harus ada cara untuk mendeteksi suatu record registrasi merupakan kunjungan lama atau baru.
         * 
         * Simpan kodingan sementara yang dapat dipakai sebagai validasi data
         * select(['registrasi.uuid', 'registrasi.tanggal', 'registrasi.nama_pasien'])
         *  ->selectRaw('CASE WHEN r.urutan = 1 THEN TRUE ELSE FALSE END as kunjungan_baru')
         */

        $data = Registrasi::selectRaw('COUNT(registrasi.uuid) FILTER (WHERE r.urutan = 1) as kunjungan_baru')
            ->selectRaw('COUNT(registrasi.uuid) as total_kunjungan')
            ->where('registrasi.delete_soft', 1)
            ->where('registrasi.rekam_medis', '!=', 'AP020739')
            ->joinSub(
                fn($q) => $q->from('registrasi')->select(['uuid'])
                    ->selectRaw('RANK() OVER (PARTITION BY pasien_uuid ORDER BY tanggal ASC) as urutan')
                , 'r', 'r.uuid', '=', 'registrasi.uuid'
            );

        if ($request->dateRange) {
            $data->where('registrasi.tanggal', '>=', $request->dateRange['start'])
                ->where('registrasi.tanggal', '<=', $request->dateRange['end']);
        }

        return response()->json($data->first());
    }

    public function statsjumlahkunjungan(Request $request){
        $data = Registrasi::selectRaw("COUNT(registrasi.uuid) FILTER (WHERE registrasi.jalur_masuk = 'Rawat Jalan') as rawat_jalan")
            ->selectRaw("COUNT(registrasi.uuid) FILTER (WHERE registrasi.jalur_masuk = 'Rawat Inap') as rawat_inap")
            ->selectRaw("COUNT(registrasi.uuid) FILTER (WHERE registrasi.jalur_masuk = 'One Day Care') as odc")
            ->where('registrasi.delete_soft', 1)
            ->where('registrasi.rekam_medis', '!=', 'AP020739');

        if ($request->dateRange) {
            $data->where('registrasi.tanggal', '>=', $request->dateRange['start'])
                ->where('registrasi.tanggal', '<=', $request->dateRange['end']);
        }

        return response()->json($data->first());
    }

    public function statspenyakitterbanyak(Request $request){
        $data = Icd10::select(['icd_ten.nama', 'icd_ten.kode', \DB::raw('COUNT(pd.uuid) as jumlah')])
            ->leftJoinSub(
                \DB::table('pemeriksaan_dokter')->select(['pemeriksaan_dokter.uuid', 'pemeriksaan_diagnosa_kode'])
                    ->leftJoin('registrasi', 'registrasi.uuid', '=', 'pemeriksaan_dokter.registrasi_uuid')
                    ->where(function($q) use ($request){
                        if ($request->dateRange) {
                            $q->where('registrasi.tanggal', '>=', $request->dateRange['start'])
                                ->where('registrasi.tanggal', '<=', $request->dateRange['end']);
                        }

                        return $q;
                    })
                    ->where('registrasi.delete_soft', 1)
                    ->where('registrasi.rekam_medis', '!=', 'AP020739')
                , 'pd', 'pd.pemeriksaan_diagnosa_kode', '=', 'icd_ten.uuid'
            )
            ->where('icd_ten.delete_soft', 1)
            ->groupBy('icd_ten.nama')
            ->groupBy('icd_ten.kode')
            ->orderBy('jumlah', 'DESC')
            ->limit(10);

        return response()->json($data->get());
    }
}