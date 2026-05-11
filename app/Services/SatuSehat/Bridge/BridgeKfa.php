<?php

namespace App\Services\SatuSehat\Bridge;

class BridgeKfa extends BridgeBase
{
    protected function baseUrl(): string
    {
        return $this->config->getUrlKfa();
    }
}
