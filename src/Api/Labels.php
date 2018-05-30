<?php

namespace OpsWay\Shipmile\Api;

class Labels extends BaseApi
{
    const API_PATH_POST = 'labels';

    public function createA5(array $data, array $params = [])
    {
        return $this->client->post(static::API_PATH_POST . '?label_format=a5_in_a4', $data);
    }

    public function createA6(array $data, array $params = [])
    {
        return $this->client->post(static::API_PATH_POST . '?label_format=a6_in_a4', $data);
    }
}