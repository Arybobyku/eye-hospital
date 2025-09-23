<?php

namespace App\Exports;

use DB;
use App\Models\CaraBayar;
use App\Models\CaraBayarTindakanRawatJalan;
use App\Models\ListPaketBedahBaru;
use App\Models\PaketBedah;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UploadPaketBEdah implements ToCollection, WithHeadingRow
{

    public function __construct() {}

    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();

            $paketBedah = new PaketBedah();
            $paketBedah->uuid = Uuid::uuid4();
            $paketBedah->nama = $rows[0]['name'];
            $paketBedah->uuid_carabayar = $rows[0]['carabayar_uuid'];
            $paketBedah->nama_carabayar = $rows[0]['carabayar'];
            // $paketBedah->total = $request->total;
            // $paketBedah->pengguna_uuid = $request->pengguna_uuid && $request->pengguna_uuid != '' ? $request->pengguna_uuid : '-';
            // $paketBedah->nama_dokter = $request->nama_dokter && $request->nama_dokter != '' && $request->nama_dokter != 'Silahkan Pilih' ? $request->nama_dokter : '-';
            // $paketBedah->keterangan = $request->keterangan;
            $paketBedah->save();

            foreach ($rows as $row) {
                $quantity = (int) $row['quantity'];
                if ($quantity > 0) {

                    $item = new ListPaketBedahBaru();
                    $item->uuid = Uuid::uuid4();
                    $item->paket_bedah_uuid = $paketBedah->uuid;
                    $item->nama_paket_bedah = $paketBedah->nama;
                    $item->label = $row['label'];
                    $item->label = $row['label'];
                    $item->sub_label = $row['sublabel'];
                    $item->nama = $row['nama'];
                    $item->quantity = $row['quantity'];
                    $item->harga = $row['harga'];

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
