<?php

namespace OpsWay\Shipmile;

use GuzzleHttp\Client as BaseClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Uri;
use OpsWay\Shipmile\Exception\BaseException;
use OpsWay\Shipmile\Exception\ApiErrorException;
use OpsWay\Shipmile\Exception\UnexceptedResponseException;

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

		$response = $this->httpClient->post($url, $body); 
		return $this->processResult($response);
	}

	public function processResult(ResponseInterface $response) {
	    $responseData = json_decode($response->getBody()->getContents(), TRUE);
	    if(isset($responseData['errors'])) {
	        throw new BaseException('Error occured: ' . $response->getStatusCode() . '. ' . $response->getReasonPhrase() . '. Message: '  . $responseData['errors'][0]['message']);
	    } 
	    elseif(isset($responseData['message'])) {
	        throw new ApiErrorException('Internal error: ' . $responseData['message']);
	    } elseif ($responseData === null) {
	    	throw new UnexceptedResponseException('Unexcepted response');
	    }
	    return $responseData;
	}
}