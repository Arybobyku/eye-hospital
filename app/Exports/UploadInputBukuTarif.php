<?php

namespace App\Exports;

use App\Models\BukuTarif;
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

class UploadInputBukuTarif implements ToCollection, WithHeadingRow
{

    public function __construct() {}

    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();

            foreach ($rows as $d) {

                $item = new BukuTarif();
                $item->uuid = Uuid::uuid4();
                $item->label = $d['label'];
                $item->sub_label = $d['sub_label'];
                $item->nama = $d['nama'];
                $item->harga = (int) round($d['harga']);
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
