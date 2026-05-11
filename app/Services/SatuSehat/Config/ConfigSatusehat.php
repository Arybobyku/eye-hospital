<?php

namespace App\Services\SatuSehat\Config;

class ConfigSatusehat
{
    protected string $urlAuth;
    protected string $urlBase;
    protected string $urlConsent;
    protected string $urlKfa;
    protected string $urlKfaV2;
    protected string $urlKyc;
    protected string $clientId;
    protected string $clientSecret;
    protected string $organizationId;
    protected string $locationId;

    public function __construct()
    {
        $this->urlAuth        = env('API_SATUSEHAT_AUTH',   '');
        $this->urlBase        = env('API_SATUSEHAT_BASE',   '');
        $this->urlConsent     = env('API_SATUSEHAT_CONSENT','');
        $this->urlKfa         = env('API_SATUSEHAT_KFA',    '');
        $this->urlKfaV2       = env('API_SATUSEHAT_KFA_V2', '');
        $this->urlKyc         = env('API_SATUSEHAT_KYC',    '');
        $this->clientId       = env('CLIENT_ID_SATUSEHAT',       '');
        $this->clientSecret   = env('CLIENT_SECRET_SATUSEHAT',   '');
        $this->organizationId = env('SATUSEHAT_ORGANIZATION_ID', '');
        $this->locationId     = env('SATUSEHAT_LOCATION_ID',     '');
    }

    public function getUrlAuth():       string { return $this->urlAuth; }
    public function getUrlBase():       string { return $this->urlBase; }
    public function getUrlConsent():    string { return $this->urlConsent; }
    public function getUrlKfa():        string { return $this->urlKfa; }
    public function getUrlKfaV2():      string { return $this->urlKfaV2; }
    public function getUrlKyc():        string { return $this->urlKyc; }
    public function getClientId():      string { return $this->clientId; }
    public function getClientSecret():  string { return $this->clientSecret; }
    public function getOrganizationId(): string { return $this->organizationId; }
    public function getLocationId():    string { return $this->locationId; }

    /** @deprecated Gunakan getter spesifik */
    public function setUrlAuth():    string { return $this->urlAuth; }
    public function setUrlBase():    string { return $this->urlBase; }
    public function setUrlConsent(): string { return $this->urlConsent; }
    public function setUrlKfa():     string { return $this->urlKfa; }
    public function setUrlKfaV2():   string { return $this->urlKfaV2; }
    public function setUrlKyc():     string { return $this->urlKyc; }

    /**
     * Kembalikan credentials sebagai URL-encoded string untuk OAuth2 client_credentials.
     */
    public function getCredentials(): string
    {
        return http_build_query([
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);
    }

    /** @deprecated Gunakan getCredentials() */
    public function setCredentials(): string
    {
        return $this->getCredentials();
    }
}
