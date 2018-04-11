<?php 

namespace OpsWay\Shipmile\Api;

class Shipments extends BaseApi {
	const API_PATH = 'shipments';
	const API_PATH_POST = 'shipments/bulk';

	public function track(string $shipmentId) {		
		$response = $this->client->get(static::API_PATH . '/', $shipmentId . '/track');

		return $response;
	}

	public function bulkTracking(array $shipmentIds) {
		$response = $this->client->post(static::API_PATH . '/tracking/bulk', $shipmentIds);

		return $response;
	}
}