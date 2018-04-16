<?php 
namespace OpsWay\Shipmile\Api;

use GuzzleHttp\Psr7\Stream;
use OpsWay\Shipmile\Client;

class BaseApi {
	const API_PATH = 'base_path';

	protected $client;

	public function __construct(Client $client) {
		$this->client = $client;
	}

	public function getList(array $filters = []) {
		$response = $this->client->getList(static::API_PATH, $filters);

		return $response;
	}

	public function get(string $id, array $params = []) {
		$response = $this->client->get(static::API_PATH, $id, $params);

		return $response;
	}

	public function create(array $data, array $params = []) {
		$response = $this->client->post(static::API_PATH_POST, $data, $params);

		return $response;
	}
}