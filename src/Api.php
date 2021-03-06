<?php

namespace OpsWay\Shipmile;

class Api
{

    protected $authToken;

    protected $client;

    public function __construct(string $authToken, bool $toProduction)
    {
        $this->authToken = $authToken;
        $this->toProduction = $toProduction;
    }

    public function getClient()
    {
        if ($this->client === null) {
            $this->setClient(new Client($this->authToken, $this->toProduction));
        }

        return $this->client;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    public function shipments()
    {
        return new Api\Shipments($this->getClient());
    }

    public function addresses()
    {
        return new Api\Addresses($this->getClient());
    }

    public function pickups()
    {
        return new Api\Pickups($this->getClient());
    }

    public function labels()
    {
        return new Api\Labels($this->getClient());
    }

    public function pincodes()
    {
        return new Api\Pincodes($this->getClient());
    }

}