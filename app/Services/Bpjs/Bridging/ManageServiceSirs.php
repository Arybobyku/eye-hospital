<?php

namespace App\Services\Bpjs\Bridging;
abstract class ManageServiceSirs
{
    protected $urlEndpoint;

    protected $user;

    protected $pass;

    /**
     * abstract method getUrl
     */
    abstract public function setUrl();

    /**
     * abstract method getConsId
     */
    abstract public function setUser();

    /**
     * abstract method getSecretKey
     */
    abstract public function setPass();
}