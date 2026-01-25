<?php

namespace App\Exports;

use DB;
use App\Models\CaraBayar;
use App\Models\CaraBayarTindakanRawatJalan;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UploadMetodePembayaran implements ToCollection, WithHeadingRow
{

    public function __construct() {}

    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();

            $caraBayar = new CaraBayar();
            $caraBayar->uuid = Uuid::uuid4();
            $caraBayar->nama = $rows[0]['metode'];
            $caraBayar->kode = '-';
            $caraBayar->status = 'active';
            $caraBayar->save();

            foreach ($rows as $row) {
                $harga = (int) $row['harga'];
                if ($harga> 0) {

                    $item = new CaraBayarTindakanRawatJalan();

                    $item->uuid = Uuid::uuid4();
                    $item->carabayar_uuid = $caraBayar->uuid;
                    $item->carabayar_nama = $caraBayar->nama;
                    $item->tindakan_rawat_jalan_uuid = $row['uuid'];
                    $item->nama_tindakan_rawat_jalan = $row['nama'];
                    $item->jenis = $row['sub_label'];
                    $item->harga = $row['harga'];
                    $item->default = $row['default'];

                    $item->save();
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['hasil' => 'gagal']);
        }
    }
}
