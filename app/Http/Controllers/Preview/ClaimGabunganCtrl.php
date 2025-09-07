<?php

namespace App\Http\Controllers\Preview;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Exports\TindakanPasien;
use App\Exports\RegistrasiPasien;
use App\Models\LogPengguna;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\LayananPasien;
use App\Models\ResepRacikan;

class ClaimGabunganCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function get(Request $request) {
		$uuid = '';
		if ($request->posisi == 'prodia') { $uuid = 'f93e2aeb-0f76-4f16-8bc0-b291eb16e740'; }
		else if ($request->posisi == 'bpjstk') { $uuid = 'd494b806-9af6-4ccc-af2a-50be75e0814f'; }
		else if ($request->posisi == 'socfindo') { $uuid = '91cf4fa7-f35f-41e2-8e29-0ed6a3982da3'; }
		else if ($request->posisi == 'pln') { $uuid = 'b20fdd4c-a0e7-45df-94c7-2877eb82b6d0'; }

		$data = Registrasi::with('layanan')->where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('carabayar_uuid', '=', $uuid)
									->whereDate('tanggal_bayar', '>=', $request->dari)
									->whereDate('tanggal_bayar', '<=', $request->ke)
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Jalan')
									->orWhere('jenis', '=', 'Rawat Inap')
									->orWhere('jenis', '=', 'One Day Care');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->where(function($q) {
										$q->where('status_dokter', '=', 'Sudah Diperiksa');
									})
									->get();

		$kwitansi = Registrasi::where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('carabayar_uuid', '=', $uuid)
									->whereDate('tanggal_bayar', '>=', $request->dari)
									->whereDate('tanggal_bayar', '<=', $request->ke)
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Jalan')
									->orWhere('jenis', '=', 'Rawat Inap')
									->orWhere('jenis', '=', 'One Day Care');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->where(function($q) {
										$q->where('status_dokter', '=', 'Sudah Diperiksa');
									})
									->first();

		$no_kwitansi = '-';
		$claim_additional = '-';
		if ($kwitansi) { $no_kwitansi = $kwitansi->kwitansi_claim; $claim_additional = $kwitansi->claim_additional; }

		return response()->json([
			'data' => $data,
			'posisi' => $request->posisi,
			'dari' => $request->dari,
			'ke' => $request->ke,
			'no_kwitansi' => $no_kwitansi,
			'claim_additional' => $claim_additional,
		]);
	}

	public function add(Request $request) {
		$uuid = '';
		if ($request->posisi == 'prodia') { $uuid = 'f93e2aeb-0f76-4f16-8bc0-b291eb16e740'; }
		else if ($request->posisi == 'bpjstk') { $uuid = 'd494b806-9af6-4ccc-af2a-50be75e0814f'; }
		else if ($request->posisi == 'socfindo') { $uuid = '91cf4fa7-f35f-41e2-8e29-0ed6a3982da3'; }
		else if ($request->posisi == 'pln') { $uuid = 'b20fdd4c-a0e7-45df-94c7-2877eb82b6d0'; }

		$arr = array('kwitansi_claim' => $request->kwitansi_claim, 'claim_additional' => $request->claim_additional);

		$update = Registrasi::where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('carabayar_uuid', '=', $uuid)
									->whereDate('tanggal_bayar', '>=', $request->dari)
									->whereDate('tanggal_bayar', '<=', $request->ke)
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Jalan')
										->orWhere('jenis', '=', 'Rawat Inap')
										->orWhere('jenis', '=', 'One Day Care');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->where(function($q) {
										$q->where('status_dokter', '=', 'Sudah Diperiksa');
									})
									->update($arr);

		$data = Registrasi::with('layanan')->where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('carabayar_uuid', '=', $uuid)
									->whereDate('tanggal_bayar', '>=', $request->dari)
									->whereDate('tanggal_bayar', '<=', $request->ke)
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Jalan')
									->orWhere('jenis', '=', 'Rawat Inap')
									->orWhere('jenis', '=', 'One Day Care');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->where(function($q) {
										$q->where('status_dokter', '=', 'Sudah Diperiksa');
									})
									->get();

		$kwitansi = Registrasi::where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('carabayar_uuid', '=', $uuid)
									->whereDate('tanggal_bayar', '>=', $request->dari)
									->whereDate('tanggal_bayar', '<=', $request->ke)
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Jalan')
									->orWhere('jenis', '=', 'Rawat Inap')
									->orWhere('jenis', '=', 'One Day Care');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->where(function($q) {
										$q->where('status_dokter', '=', 'Sudah Diperiksa');
									})
									->first();

		$no_kwitansi = '-';
		$claim_additional = '-';
		if ($kwitansi) { $no_kwitansi = $kwitansi->kwitansi_claim; $claim_additional = $kwitansi->claim_additional; }

		return response()->json([
			'data' => $data,
			'posisi' => $request->posisi,
			'dari' => $request->dari,
			'ke' => $request->ke,
			'no_kwitansi' => $no_kwitansi,
			'claim_additional' => $claim_additional,
		]);
	}

	public function ubah(Request $request) {
		$uuid = '';
		if ($request->posisi == 'prodia') { $uuid = 'f93e2aeb-0f76-4f16-8bc0-b291eb16e740'; }
		else if ($request->posisi == 'bpjstk') { $uuid = 'd494b806-9af6-4ccc-af2a-50be75e0814f'; }
		else if ($request->posisi == 'socfindo') { $uuid = '91cf4fa7-f35f-41e2-8e29-0ed6a3982da3'; }
		else if ($request->posisi == 'pln') { $uuid = 'b20fdd4c-a0e7-45df-94c7-2877eb82b6d0'; }

		$arr = array('status_claim' => 'Sudah Diterima');

		$update = Registrasi::where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('carabayar_uuid', '=', $uuid)
									->whereDate('tanggal_bayar', '>=', $request->dari)
									->whereDate('tanggal_bayar', '<=', $request->ke)
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Jalan')
										->orWhere('jenis', '=', 'Rawat Inap')
										->orWhere('jenis', '=', 'One Day Care');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->where(function($q) {
										$q->where('status_dokter', '=', 'Sudah Diperiksa');
									})
									->update($arr);

		$data = Registrasi::with('layanan')->where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('carabayar_uuid', '=', $uuid)
									->whereDate('tanggal_bayar', '>=', $request->dari)
									->whereDate('tanggal_bayar', '<=', $request->ke)
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Jalan')
									->orWhere('jenis', '=', 'Rawat Inap')
									->orWhere('jenis', '=', 'One Day Care');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->where(function($q) {
										$q->where('status_dokter', '=', 'Sudah Diperiksa');
									})
									->get();

		$kwitansi = Registrasi::where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('carabayar_uuid', '=', $uuid)
									->whereDate('tanggal_bayar', '>=', $request->dari)
									->whereDate('tanggal_bayar', '<=', $request->ke)
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Jalan')
									->orWhere('jenis', '=', 'Rawat Inap')
									->orWhere('jenis', '=', 'One Day Care');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->where(function($q) {
										$q->where('status_dokter', '=', 'Sudah Diperiksa');
									})
									->first();

		$no_kwitansi = '-';
		$claim_additional = '-';
		if ($kwitansi) { $no_kwitansi = $kwitansi->kwitansi_claim; $claim_additional = $kwitansi->claim_additional; }

		return response()->json([
			'data' => $data,
			'posisi' => $request->posisi,
			'dari' => $request->dari,
			'ke' => $request->ke,
			'no_kwitansi' => $no_kwitansi,
			'claim_additional' => $claim_additional,
		]);
	}

	public function claim($posisi, $dari, $ke) {

		$uuid = '';
		$nama = '';
		if ($posisi == 'prodia') { $uuid = 'f93e2aeb-0f76-4f16-8bc0-b291eb16e740'; }
		else if ($posisi == 'bpjstk') { $uuid = 'd494b806-9af6-4ccc-af2a-50be75e0814f'; }
		else if ($posisi == 'socfindo') { $uuid = '91cf4fa7-f35f-41e2-8e29-0ed6a3982da3'; }
		else if ($posisi == 'pln') { $uuid = 'b20fdd4c-a0e7-45df-94c7-2877eb82b6d0'; }
		$pdf = \App::make('dompdf.wrapper');

		$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('carabayar_uuid', '=', $uuid)
									->whereDate('tanggal_bayar', '>=', $dari)
									->whereDate('tanggal_bayar', '<=', $ke)
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Jalan')
									->orWhere('jenis', '=', 'Rawat Inap')
									->orWhere('jenis', '=', 'One Day Care');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->where(function($q) {
										$q->where('status_dokter', '=', 'Sudah Diperiksa');
									})
									->get();

		$registrasi = Registrasi::where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('carabayar_uuid', '=', $uuid)
									->whereDate('tanggal_bayar', '>=', $dari)
									->whereDate('tanggal_bayar', '<=', $ke)
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Jalan')
									->orWhere('jenis', '=', 'Rawat Inap')
									->orWhere('jenis', '=', 'One Day Care');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->where(function($q) {
										$q->where('status_dokter', '=', 'Sudah Diperiksa');
									})
									->first();

		$grandtotal = 0;
		$grandtotalCover = 0;
		foreach ($data as $row) {
			$layananpasien = LayananPasien::where('registrasi_uuid', '=', $row->uuid)->get();
			foreach ($layananpasien as $value) {
				$grandtotal += $value->total;
			}
				$grandtotalCover += $row->cover_asuransi;
		}
		
		$pdf->loadView('print.printclaimgabungan', compact('grandtotal', 'grandtotalCover',  'registrasi'))->setPaper('a4', 'potrait');

		
    return $pdf->stream();
	}

	public function pengantar($posisi, $dari, $ke) {

		$uuid = '';
		$nama = '';
		if ($posisi == 'prodia') { $uuid = 'f93e2aeb-0f76-4f16-8bc0-b291eb16e740'; }
		else if ($posisi == 'bpjstk') { $uuid = 'd494b806-9af6-4ccc-af2a-50be75e0814f'; }
		else if ($posisi == 'socfindo') { $uuid = '91cf4fa7-f35f-41e2-8e29-0ed6a3982da3'; }
		else if ($posisi == 'pln') { $uuid = 'b20fdd4c-a0e7-45df-94c7-2877eb82b6d0'; }
		$pdf = \App::make('dompdf.wrapper');

		$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('carabayar_uuid', '=', $uuid)
									->whereDate('tanggal_bayar', '>=', $dari)
									->whereDate('tanggal_bayar', '<=', $ke)
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Jalan')
									->orWhere('jenis', '=', 'Rawat Inap')
									->orWhere('jenis', '=', 'One Day Care');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->where(function($q) {
										$q->where('status_dokter', '=', 'Sudah Diperiksa');
									})
									->get();

		$registrasi = Registrasi::where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('carabayar_uuid', '=', $uuid)
									->whereDate('tanggal_bayar', '>=', $dari)
									->whereDate('tanggal_bayar', '<=', $ke)
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Jalan')
									->orWhere('jenis', '=', 'Rawat Inap')
									->orWhere('jenis', '=', 'One Day Care');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->where(function($q) {
										$q->where('status_dokter', '=', 'Sudah Diperiksa');
									})
									->first();

		$grandtotal = 0;
		$grandtotalCover = 0;
		foreach ($data as $row) {
			$layananpasien = LayananPasien::where('registrasi_uuid', '=', $row->uuid)->get();
			foreach ($layananpasien as $value) {
				$grandtotal += $value->total;
			}
				$grandtotalCover += $row->cover_asuransi;
		}

		if ($posisi == 'pln') {
			$pdf->loadView('print.printpengantargabunganspesial', compact('grandtotal','grandtotalCover', 'registrasi'))->setPaper('a4', 'potrait');
		}
		else {
			$pdf->loadView('print.printpengantargabungan', compact('grandtotal','grandtotalCover',  'registrasi'))->setPaper('a4', 'potrait');
		}
		
    return $pdf->stream();
	}

}