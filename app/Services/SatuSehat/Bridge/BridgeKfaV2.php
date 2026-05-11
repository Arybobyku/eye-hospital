<?php

namespace App\Services\SatuSehat\Bridge;

class BridgeKfaV2 extends BridgeBase
{
    protected function baseUrl(): string
    {
        return $this->config->getUrlKfaV2();
    }
}
