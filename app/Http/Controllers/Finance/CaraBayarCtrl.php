<?php

namespace App\Http\Controllers\Finance;

use App\Exports\MetodePembayaran;
use App\Exports\TemplateUploadPembayaran;
use App\Exports\UploadMetodePembayaran;
use App\Exports\UploadUpdateLabelMetodePembayaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\CaraBayar;
use App\Models\TindakanRawatJalan;
use Maatwebsite\Excel\Facades\Excel;


class CaraBayarCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl();
	}

	public function list(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Melihat data list table pada halaman metode pembayaran');

		$list = '';
		$total = '';
		$page = $request->page - 1;
		$skip = $page * $this->take;
		$search = $request->search;
		$column = $request->column;

		$data = DB::table('carabayar as cb')
			->leftJoin('carabayar_tindakan_rawat_jalan as trj', 'trj.carabayar_uuid', '=', 'cb.uuid')
			->leftJoin('carabayar_tindakan_non_bedah as tnb', 'tnb.carabayar_uuid', '=', 'cb.uuid')
			->leftJoin('carabayar_tindakan_bedah as tb', 'tb.carabayar_uuid', '=', 'cb.uuid')
			->leftJoin('carabayar_kamar as ck', 'ck.carabayar_uuid', '=', 'cb.uuid')
			->where('cb.delete_soft', 1)
			->when($search, function ($q) use ($column, $search) {
				if (!empty($column)) {
					$q->where("cb.$column", 'ilike', "%$search%");
				}
			})
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
			$item->tindakanrawatjalan = json_decode($item->tindakanrawatjalan, true);
			$item->tindakannonbedah   = json_decode($item->tindakannonbedah, true);
			$item->tindakanbedah      = json_decode($item->tindakanbedah, true);
			$item->jeniskamar         = json_decode($item->jeniskamar, true);
			return $item;
		});

		return response()->json([
			'data' => $data,
			'total' => $data->count(),
		]);


		if ($request->search != "") {
			$data = CaraBayar::where('delete_soft', '=', 1)
				->where($column, 'ilike', '%' . $search . '%')
				->orderBy('id', 'desc')
				->skip($skip)->take($this->take)
				->get();
			$total = CaraBayar::where('delete_soft', '=', 1)
				->where($column, 'ilike', '%' . $search . '%')
				->orderBy('id', 'desc')->count();
		} else {
			$data = CaraBayar::where('delete_soft', '=', 1)
				->orderBy('id', 'desc')
				->skip($skip)->take($this->take)
				->get();

			$total = CaraBayar::where('delete_soft', '=', 1)->orderBy('id', 'desc')->count();
		}

		return response()->json(['data' => $data, 'total' => $total]);
	}

	public function add(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Menambahkan satu metode pembayaran dengan nama "' . $request->nama . '".');

		$uuid = '';
		$loop = false;
		do {
			$uuid = Uuid::uuid4();
			$check = CaraBayar::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);

		try {
			DB::beginTransaction();

			$item = new CaraBayar();
			$item->uuid = $uuid;
			$item->nama = $request->nama;
			$item->save();

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function edit(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = CaraBayar::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil infomasi tentang metode pembayaran dengan nama "' . $data->nama . '" dan id "' . $data->id . '" untuk ditampilkan dihalaman edit metode pembayaran');
		}

		return response()->json(['data' => $data]);
	}

	public function update(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$get = CaraBayar::where('uuid', '=', $request->uuid)->first();
		PenggunaHelp::log('Mengupdate metode pembayaran dengan nama "' . $get->nama . '" menjadi nama "' . $request->nama . '"');

		$arr = array(
			'nama' => $request->nama
		);

		try {
			DB::beginTransaction();

			$update = CaraBayar::where('uuid', '=', $request->uuid)->update($arr);

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function remove(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = CaraBayar::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus metode pembayaran dengan nama "' . $data->nama . '" dan id "' . $data->id . '".');
		}

		$arr = array('delete_soft' => 0);

		try {
			DB::beginTransaction();

			$remove = CaraBayar::where('uuid', '=', $request->uuid)->update($arr);

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function api(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = CaraBayar::where('delete_soft', '=', '1')->where('nama', 'ilike', '%' . $request->keyword . '%')->limit(10)->get();
		return response()->json(['data' => $data]);
	}


	public function exportMetodePembayaran()
	{
		$filename = date('Y-m-d') . '-metode-pembayaran.xlsx';
		return \Excel::download(new MetodePembayaran(), $filename);
	}


	public function downloadTemplateUploadPembayaran($metode)
	{
		$filename = 'template-upload.xlsx';
		return \Excel::download(new TemplateUploadPembayaran($metode), $filename);
	}

	public function uploadMetodePembayaran(Request $request)
	{
		$request->validate([
			'file' => 'required|file|mimes:xlsx,csv,xls',
		]);

		Excel::import(new UploadMetodePembayaran, $request->file('file'));

		return back()->with('success', 'Upload & import berhasil!');
	}

	public function uploadUpdateLabelMetodePembayaran(Request $request)
	{
		$request->validate([
			'file' => 'required|file|mimes:xlsx,csv,xls',
		]);

		Excel::import(new UploadUpdateLabelMetodePembayaran, $request->file('file'));

		return back()->with('success', 'Upload & import berhasil!');
	}
}
