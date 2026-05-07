<?php

namespace App\Services\SatuSehat\Bridge;

class BridgeConsent extends BridgeBase
{
    protected function baseUrl(): string
    {
        return $this->config->getUrlConsent();
    }
}
