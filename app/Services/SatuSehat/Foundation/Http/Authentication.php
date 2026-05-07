<?php

namespace App\Services\SatuSehat\Foundation\Http;

use App\Services\SatuSehat\Foundation\Handler\SimpleCurlFactory;
use Illuminate\Support\Facades\Cache;

class Authentication
{
    protected string $accessToken;

    /** Token SatuSehat berlaku 3600 detik; cache 55 menit agar aman */
    public const CACHE_TTL_MINUTES = 55;
    public const CACHE_KEY         = 'satusehat_access_token';
    public const CACHE_KEY_META    = 'satusehat_access_token_meta';

    /**
     * @param string $endpoint   URL lengkap endpoint auth, mis.
     *                           https://api-satusehat-stg.dto.kemkes.go.id/authr4/accesstoken?grant_type=client_credentials
     * @param string $credentials  URL-encoded client_id & client_secret
     */
    public function __construct(string $endpoint, string $credentials)
    {
        $this->accessToken = $this->resolveToken($endpoint, $credentials);
    }

    public function getToken(): string
    {
        return $this->accessToken;
    }

    /** @deprecated Gunakan getToken() */
    public function setToken(): string
    {
        return $this->accessToken;
    }

    private function resolveToken(string $endpoint, string $credentials): string
    {
        // Ambil dari cache jika masih valid
        if (Cache::has(self::CACHE_KEY)) {
            return Cache::get(self::CACHE_KEY);
        }

        // Endpoint sudah berupa URL lengkap — gunakan langsung
        $curl     = new SimpleCurlFactory();
        $response = $curl->request($endpoint, 'POST', $credentials, null);
        $result   = json_decode($response, true);

        if (empty($result['access_token'])) {
            throw new \RuntimeException(
                'SatuSehat Authentication gagal. Response: ' . $response
            );
        }

        $token     = $result['access_token'];
        $expiresAt = now()->addMinutes(self::CACHE_TTL_MINUTES)->toDateTimeString();

        // Simpan token ke cache
        Cache::put(self::CACHE_KEY, $token, now()->addMinutes(self::CACHE_TTL_MINUTES));

        // Simpan meta (expiry timestamp) agar halaman token bisa menampilkannya
        Cache::put(self::CACHE_KEY_META, [
            'expires_at'  => $expiresAt,
            'fetched_at'  => now()->toDateTimeString(),
        ], now()->addMinutes(self::CACHE_TTL_MINUTES));

        return $token;
    }

    /**
     * Paksa refresh token (hapus cache lama).
     */
    public static function forgetToken(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget(self::CACHE_KEY_META);
    }

    /**
     * Kembalikan status cache token saat ini tanpa memicu fetch baru.
     */
    public static function getStatus(): array
    {
        $cached = Cache::has(self::CACHE_KEY);
        $token  = $cached ? Cache::get(self::CACHE_KEY) : null;
        $meta   = Cache::get(self::CACHE_KEY_META, []);

        return [
            'cached'       => $cached,
            'token_masked' => $token ? (substr($token, 0, 24) . str_repeat('*', 20)) : null,
            'expires_at'   => $meta['expires_at'] ?? null,
            'fetched_at'   => $meta['fetched_at']  ?? null,
        ];
    }
}
