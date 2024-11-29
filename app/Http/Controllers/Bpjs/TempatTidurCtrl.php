<?php

namespace App\Http\Controllers\Bpjs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Bpjs\Bridging\Sirs\BridgeSirs;


class TempatTidurCtrl extends Controller
{
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeSirs;
    }

    public function getTempatTidur()
    {
        $url = 'Fasyankes';
        $tempattidur = $this->bridging->getRequest($url);
        // return $tempattidur;

		return response()->json(['data' => $tempattidur]);

    }

    public function getReferensi()
    {
        $endpoint = "Referensi/tempat_tidur";
        $referensi = $this->bridging->getRequest($endpoint);
        return $referensi;
    }
}
