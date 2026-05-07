<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SatuSehat\Foundation\Http\Authentication;
use App\Services\SatuSehat\Config\ConfigSatusehat;
use PenggunaHelp;

class TokenCtrl extends Controller
{
    private string $error = 'next';

    /** Path auth endpoint — harus identik dengan BridgeBase::ENDPOINT_AUTH */
    private const ENDPOINT_AUTH = 'accesstoken?grant_type=client_credentials';

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = PenggunaHelp::acl();
    }

    /**
     * GET current token status (masked token, cached?, expiry).
     * Tidak memicu fetch baru — hanya membaca cache.
     */
    public function status(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $config  = new ConfigSatusehat();
        $status  = Authentication::getStatus();

        return response()->json([
            'data' => array_merge($status, [
                'client_id'     => $config->getClientId()
                                    ? substr($config->getClientId(), 0, 8) . '****'
                                    : '-',
                'endpoint_auth' => $config->getUrlAuth() . self::ENDPOINT_AUTH,
            ]),
        ]);
    }

    /**
     * POST — paksa refresh token:
     *   1. Hapus cache lama (via Authentication::forgetToken)
     *   2. Buat Authentication baru dengan URL IDENTIK dengan BridgeBase
     *      sehingga semua request berikutnya memakai token yang sama
     */
    public function refresh(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        try {
            $config = new ConfigSatusehat();

            // 1. Hapus cache
            Authentication::forgetToken();

            // 2. Fetch token baru — URL harus sama persis dengan BridgeBase
            $auth  = new Authentication(
                $config->getUrlAuth() . self::ENDPOINT_AUTH,
                $config->getCredentials()
            );

            $status = Authentication::getStatus();

            PenggunaHelp::log('Refresh Access Token SatuSehat manual');

            return response()->json([
                'data'         => 'berhasil',
                'token_masked' => $status['token_masked'],
                'expiry'       => $status['expires_at'],
                'fetched_at'   => $status['fetched_at'],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'data'    => 'gagal',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
