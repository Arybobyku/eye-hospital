<?php

namespace App\Services\SatuSehat\Bridge;

use App\Services\SatuSehat\Config\ConfigSatusehat;
use App\Services\SatuSehat\Foundation\Handler\SimpleCurlFactory;
use App\Services\SatuSehat\Foundation\Http\Authentication;
use Illuminate\Support\Facades\DB;

class BridgeBase extends SimpleCurlFactory
{
    protected Authentication $auth;
    protected string $accessToken;
    protected ConfigSatusehat $config;

    /** Konteks log (e.g. 'patient_sync', 'encounter_sync', 'wilayah', 'other') — bisa diset dari luar */
    public string $logContext = 'other';

    /** Set false untuk menonaktifkan logging (misalnya saat fetch token) */
    protected bool $enableLogging = true;

    private const ENDPOINT_AUTH = 'accesstoken?grant_type=client_credentials';

    public function __construct()
    {
        $this->config      = new ConfigSatusehat();
        $this->auth        = new Authentication(
            $this->config->getUrlAuth() . self::ENDPOINT_AUTH,
            $this->config->setCredentials()
        );
        $this->accessToken = $this->auth->getToken();
    }

    /**
     * URL dasar yang digunakan oleh subclass ini.
     * Subclass override method ini jika perlu URL berbeda.
     */
    protected function baseUrl(): string
    {
        return $this->config->getUrlBase();
    }

    // ── HTTP Verbs ────────────────────────────────────────────────────

    public function getRequest(string $endpoint): string
    {
        return $this->request($this->baseUrl() . $endpoint, 'GET', '', $this->accessToken);
    }

    public function postRequest(string $endpoint, $data): string
    {
        $body = is_array($data) ? json_encode($data) : $data;
        return $this->request($this->baseUrl() . $endpoint, 'POST', $body, $this->accessToken);
    }

    public function putRequest(string $endpoint, $data): string
    {
        $body = is_array($data) ? json_encode($data) : $data;
        return $this->request($this->baseUrl() . $endpoint, 'PUT', $body, $this->accessToken);
    }

    public function patchRequest(string $endpoint, $data): string
    {
        $body = is_array($data) ? json_encode($data) : $data;
        return $this->request($this->baseUrl() . $endpoint, 'PATCH', $body, $this->accessToken);
    }

    public function deleteRequest(string $endpoint): string
    {
        return $this->request($this->baseUrl() . $endpoint, 'DELETE', '', $this->accessToken);
    }

    // ── JSON Shortcuts (dengan logging) ────────────────────────────────

    public function getJson(string $endpoint): array
    {
        return $this->callWithLog('GET', $endpoint, null);
    }

    public function postJson(string $endpoint, $data): array
    {
        return $this->callWithLog('POST', $endpoint, $data);
    }

    public function putJson(string $endpoint, $data): array
    {
        return $this->callWithLog('PUT', $endpoint, $data);
    }

    public function patchJson(string $endpoint, $data): array
    {
        return $this->callWithLog('PATCH', $endpoint, $data);
    }

    /** @deprecated Gunakan putRequest() */
    public function puttRequest(string $endpoint, $data): string
    {
        return $this->putRequest($endpoint, $data);
    }

    // ── Logging Helper ─────────────────────────────────────────────────

    /**
     * Wrapper yang memanggil request, decode JSON, dan simpan log ke DB.
     */
    protected function callWithLog(string $method, string $endpoint, $data): array
    {
        $startMs     = (int) round(microtime(true) * 1000);
        $fullUrl     = $this->baseUrl() . $endpoint;
        $requestBody = null;

        if ($data !== null) {
            $requestBody = is_string($data) ? $data : json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        $rawResponse  = '';
        $decoded      = [];
        $exception    = null;

        try {
            if ($method === 'GET') {
                $rawResponse = $this->getRequest($endpoint);
            } elseif ($method === 'POST') {
                $rawResponse = $this->postRequest($endpoint, $data);
            } elseif ($method === 'PUT') {
                $rawResponse = $this->putRequest($endpoint, $data);
            } elseif ($method === 'PATCH') {
                $rawResponse = $this->patchRequest($endpoint, $data);
            }

            $decoded = json_decode($rawResponse, true) ?? [];
        } catch (\Throwable $e) {
            $exception = $e;
        }

        $durationMs = (int) round(microtime(true) * 1000) - $startMs;
        $httpCode   = $this->lastHttpCode;
        $isSuccess  = $httpCode >= 200 && $httpCode < 300;

        // Simpan log ke DB (jangan blokir eksekusi jika gagal)
        if ($this->enableLogging) {
            try {
                DB::table('satusehat_api_logs')->insert([
                    'method'        => $method,
                    'url'           => $fullUrl,
                    'request_body'  => $requestBody,
                    'response_body' => $rawResponse !== '' ? $rawResponse : null,
                    'http_code'     => $httpCode ?: null,
                    'context'       => $this->logContext,
                    'duration_ms'   => $durationMs,
                    'is_success'    => $isSuccess,
                    'created_at'    => now(),
                ]);
            } catch (\Throwable) {
                // Logging gagal — jangan ganggu alur utama
            }
        }

        if ($exception !== null) {
            throw $exception;
        }

        return $decoded;
    }
}
