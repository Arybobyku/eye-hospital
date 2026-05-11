<?php

namespace App\Services\SatuSehat\Foundation\Handler;

class SimpleCurlFactory
{
    /**
     * Kirim HTTP request ke SatuSehat API.
     *
     * @param  string      $endpoint
     * @param  string      $method      GET | POST | PUT | PATCH | DELETE
     * @param  string|array $payload    Body request (string JSON atau form-encoded)
     * @param  string|null $accessToken Bearer token (null = request auth tanpa token)
     * @return string|false
     */
    public function request(string $endpoint, string $method = 'GET', $payload = '', ?string $accessToken = null)
    {
        $method  = strtoupper($method);
        $headers = $this->buildHeaders($method, $accessToken);

        $ch = curl_init();

        $curlOptions = [
            CURLOPT_URL            => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING       => 'gzip, deflate',
        ];

        switch ($method) {
            case 'POST':
                $curlOptions[CURLOPT_POST]       = true;
                $curlOptions[CURLOPT_POSTFIELDS] = $payload;
                break;

            case 'PUT':
            case 'PATCH':
                $curlOptions[CURLOPT_CUSTOMREQUEST] = $method;
                $curlOptions[CURLOPT_POSTFIELDS]    = is_array($payload)
                    ? json_encode($payload)
                    : $payload;
                break;

            case 'DELETE':
                $curlOptions[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                if (!empty($payload)) {
                    $curlOptions[CURLOPT_POSTFIELDS] = is_array($payload)
                        ? json_encode($payload)
                        : $payload;
                }
                break;

            case 'GET':
            default:
                $curlOptions[CURLOPT_HTTPGET] = true;
                break;
        }

        curl_setopt_array($ch, $curlOptions);

        $result = curl_exec($ch);

        if ($result === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \RuntimeException('SatuSehat cURL error: ' . $error);
        }

        curl_close($ch);

        return $result;
    }

    /**
     * Build headers berdasarkan method dan ketersediaan access token.
     */
    private function buildHeaders(string $method, ?string $accessToken): array
    {
        // Request auth (tidak ada token) — pakai form-encoded
        if ($accessToken === null) {
            return [
                'Content-Type: application/x-www-form-urlencoded',
                'Connection: close',
            ];
        }

        // Request biasa dengan Bearer token
        return [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken,
            'Connection: close',
        ];
    }

    /**
     * Shortcut: decode JSON response menjadi array.
     */
    public function requestJson(string $endpoint, string $method = 'GET', $payload = '', ?string $accessToken = null): array
    {
        $raw    = $this->request($endpoint, $method, $payload, $accessToken);
        $result = json_decode($raw, true);

        return is_array($result) ? $result : [];
    }
}
