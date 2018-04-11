<?php

namespace OpsWay\Shipmile;

use GuzzleHttp\Client as BaseClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Uri;

class Client {

	const ENDPOINT = 'https://test.shipmile.com/v3/';

	/**
	* @var Client
	*/
	protected $httpClient;
	
	/**
	* @var string
	*/
	public $authToken;

	public function __construct(string $authToken, ClientInterface $httpClient = null, array $requestOptions = []) {
		$this->authToken = $authToken;

		$requestOptions += ['base_uri' => self::ENDPOINT, RequestOptions::HTTP_ERRORS => false, 'headers' => ['X-SM-TOKEN' => $authToken]];
		$this->httpClient = $httpClient ?: new BaseClient($requestOptions);
		
		
	}

	public function getList(string $url, array $filters) {
		return $this->processResult($this->httpClient->get($url, ['query' => $filters]));
	}

	public function get(string $url, string $id, array $params = []) {
		return $this->processResult($this->httpClient->get($url . '/' . $id, ['query' => $params]));
	}

	public function post(string $url, array $data = [], array $params = []) {
		$body = [
			'headers' => ['content-type' => 'application/json'],
			'json' => $data
		];
		return $this->processResult($this->httpClient->post($url, $body));
	}

	public function processResult(ResponseInterface $response) {
		try {
			return $response->getBody();
		} catch (\InvalidArgumentException $e) {
			$result = [
				'message' => 'Internal API error: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase(),
			];
		}
		if (isset($result['code']) && $result['code'] == 0) {
			return $result;
		}
		throw new Exception('Response from Shipmile is not successful. Message: ' . $result['message']);
	}
}