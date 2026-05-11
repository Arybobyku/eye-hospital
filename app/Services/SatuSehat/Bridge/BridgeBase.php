<?php

namespace App\Services\SatuSehat\Bridge;

use App\Services\SatuSehat\Config\ConfigSatusehat;
use App\Services\SatuSehat\Foundation\Handler\SimpleCurlFactory;
use App\Services\SatuSehat\Foundation\Http\Authentication;

class BridgeBase extends SimpleCurlFactory
{
    protected Authentication $auth;
    protected string $accessToken;
    protected ConfigSatusehat $config;

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

    // ── JSON Shortcuts ─────────────────────────────────────────────────

    public function getJson(string $endpoint): array
    {
        return json_decode($this->getRequest($endpoint), true) ?? [];
    }

    public function postJson(string $endpoint, $data): array
    {
        return json_decode($this->postRequest($endpoint, $data), true) ?? [];
    }

    public function putJson(string $endpoint, $data): array
    {
        return json_decode($this->putRequest($endpoint, $data), true) ?? [];
    }

    public function patchJson(string $endpoint, $data): array
    {
        return json_decode($this->patchRequest($endpoint, $data), true) ?? [];
    }

    /** @deprecated Gunakan putRequest() */
    public function puttRequest(string $endpoint, $data): string
    {
        return $this->putRequest($endpoint, $data);
    }
}
