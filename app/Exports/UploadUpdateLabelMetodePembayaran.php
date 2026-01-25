<?php

namespace App\Exports;

use DB;
use App\Models\CaraBayar;
use App\Models\CaraBayarTindakanRawatJalan;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UploadUpdateLabelMetodePembayaran implements ToCollection, WithHeadingRow
{

    public function __construct() {}

    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();

            foreach ($rows as $row) {
                if(isset($row['tindakan'])){                
                    $item = CaraBayarTindakanRawatJalan::where('nama_tindakan_rawat_jalan', $row['tindakan'])
                        ->where('carabayar_nama', $row['carabayar'])
                        ->first();
                    if ($item) {
                        $item->jenis = $row['sub_label'];
                        $item->save();
                    } 
                  }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['hasil' => 'gagal']);
        }
    }
}
