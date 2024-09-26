<?php

namespace App\Http\Controllers\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\LampiranRekamMedis;
use Illuminate\Http\Request;
use App\Models\Registrasi;
use PenggunaHelp;
use Ramsey\Uuid\Uuid;


class LampiranRekamMedisCtrl extends Controller
{
    private $take = 15;
    private $error = 'next';

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = \PenggunaHelp::acl();
    }

   public function lampiran(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        try {
            // \DB::beginTransaction();

            $item = new LampiranRekamMedis();
            $item->uuid = Uuid::uuid4();
            $item->lampiran = $request->lampiran;
            $item->filedata = $request->filedata;
            $item->filetype = $request->filetype;
            // $item->nama_pasien = $request->nama_pasien;
            
            // echo "item";
            // echo $item;
            $item->save();
			return response()->json(['hasil' => 'berhasil']);

        } catch (Exception $e) {
            \DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }
}
