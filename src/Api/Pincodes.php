<?php

namespace OpsWay\Shipmile\Api;

class Pincodes extends BaseApi
{
    const API_PATH = 'availability/pincode';

    public function availability(int $pincode, string $paymentType)
    {
        $response = $this->client->get(static::API_PATH, $pincode, ['payment_type' => $paymentType]);

        return $response;
    }
}