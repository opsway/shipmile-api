<?php

namespace OpsWay\Shipmile\Api;

/**
 * Class Shipments
 * @package OpsWay\Shipmile\Api
 */
class Shipments extends BaseApi
{
    const API_PATH = 'shipments';
    const API_PATH_POST = 'shipments/bulk';

    /**
     * @param string $shipmentId
     * @return mixed
     */
    public function track(string $shipmentId)
    {
        $response = $this->client->get(static::API_PATH . '/', $shipmentId . '/track');

        return $response;
    }

    /**
     * @param array $shipmentIds
     * @return mixed
     */
    public function bulkTracking(array $shipmentIds)
    {
        $response = $this->client->post(static::API_PATH . '/tracking/bulk', $shipmentIds);

        return $response;
    }

    /**
     * https://shipmile.com/docs/api/#get-all-shipments
     *
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function getAllShipments(int $page = 1, int $limit = 20)
    {
        return $this->client->getList(static::API_PATH, ['page' => $page, 'limit' => $limit > 500 ? 500 : $limit]);
    }
}