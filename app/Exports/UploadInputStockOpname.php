<?php

namespace App\Exports;

use DB;
use App\Models\CaraBayar;
use App\Models\CaraBayarTindakanRawatJalan;
use App\Models\LabelStockOpname;
use App\Models\Obat;
use App\Models\StockCatat;
use App\Models\StockOpname;
use App\Models\Unit;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UploadInputStockOpname implements ToCollection, WithHeadingRow
{

    public function __construct() {}

    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();

            $unit = Unit::where('nama', '=', $rows[0]['unit'])->where('delete_soft', '=', '1')->first();

            $labeStockOpname = new LabelStockOpname();
            $labeStockOpname->uuid = Uuid::uuid4();
            $labeStockOpname->nama = $rows[0]['nama_penginput'];
            $labeStockOpname->tanggal = $rows[0]['tanggal'];
            $labeStockOpname->jam = $rows[0]['waktu'];
            $labeStockOpname->unit_uuid = $unit->uuid;
            $labeStockOpname->nama_unit = $unit->nama;
            $labeStockOpname->save();

            $obatUuid = [];
            foreach ($rows as $d) {
                $obatUuid[] = $d['uuid'];
            }

            $dataObat = StockOpname::where('delete_soft', '=', '1')
                ->where('unit_uuid', '=', $unit->uuid)
                ->whereIn('obat_uuid', $obatUuid)
                ->get()
                ->keyBy('obat_uuid');

            foreach ($rows as $d) {

                $uuidObat = $d['uuid'];
                $jumlahFisik = (int) $d['jumlah_fisik'];

                $row = $dataObat->get($uuidObat);

                $labeling = '-';

                if (!$row) {
                    continue;
                }

                $besar = $jumlahFisik / $row->hitung_kecil;
                $kecil = abs((int)($jumlahFisik - $row->jumlah_kecil));


                if ($row->jumlah_kecil == $jumlahFisik) {
                    $labeling = 'Jumlah obat/alkes antara sistem dan fisik balance';
                } else {
                    $labeling = 'Jumlah obat/alkes antara sistem dan fisik selisih ' . $kecil;
                }

                $item = new StockCatat();
                $item->uuid = Uuid::uuid4();
                $item->label_stockopname_uuid = $labeStockOpname->uuid;
                $item->obat_uuid = $uuidObat;
                $item->nama = $row->nama;
                $item->kategori = $row->kategori;
                $item->formularium = $row->formularium;
                $item->golongan = $row->golongan;
                $item->jenis = $row->jenis;

                $item->satuan_kekuatan = '-';
                $item->jumlah_kekuatan = 0;

                $item->satuan_uuid_besar = $row->satuan_uuid_besar;
                $item->nama_satuan_besar = $row->nama_satuan_besar;
                $item->satuan_uuid_kecil = $row->satuan_uuid_kecil;
                $item->nama_satuan_kecil = $row->nama_satuan_kecil;

                $item->hitung_besar = $row->hitung_besar;
                $item->hitung_kecil = $row->hitung_kecil;

                $item->unit_uuid = $unit->uuid;
                $item->nama_unit = $unit->nama;

                $item->before_jumlah_kecil = $row->jumlah_kecil;
                $item->before_jumlah_besar = $row->jumlah_besar;

                $item->after_jumlah_kecil = $jumlahFisik;
                $item->after_jumlah_besar = $besar;

                $item->selisih_jumlah_kecil = $kecil;
                $item->selisih_jumlah_besar = abs((int)($row->jumlah_besar - $besar));;

                $item->labeling = $labeling;
                $item->save();
            }

            DB::commit();

            return response()->json(['data' => 'berhasil']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['hasil' => 'gagal']);
        }
    }
}
