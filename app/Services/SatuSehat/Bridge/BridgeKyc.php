<?php

namespace App\Services\SatuSehat\Bridge;

class BridgeKyc extends BridgeBase
{
    protected function baseUrl(): string
    {
        return $this->config->getUrlKyc();
    }
}
