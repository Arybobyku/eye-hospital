<?php

namespace App\Http\Controllers\Bedah;

use App\Http\Controllers\Controller;

class PrintDataFormBedahCtrl extends Controller
{
    public function printparsepersetujuantindakankedokteran($uuid)
    {
        $pdf = App::make('dompdf.wrapper');

        $surat = '-';

        $pdf->loadView('print.parsepersetujuantindakankedokteran')->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function printlaporanpembedahann($uuid)
    {
        $pdf = App::make('dompdf.wrapper');

        $surat = '-';

        $pdf->loadView('print.laporanpembedahan')->setPaper('a4', 'potrait');

        return $pdf->stream();
    }
}
