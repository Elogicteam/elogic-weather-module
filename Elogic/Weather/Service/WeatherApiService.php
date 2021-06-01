<?php

namespace Elogic\Weather\Service;

use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;

class WeatherApiService
{
    /**
     * API request URL
     */
    const API_REQUEST_URI = 'https://api.openweathermap.org/';

    /**
     * API request endpoint
     */
    const API_REQUEST_ENDPOINT = 'data/2.5/weather';

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * GitApiService constructor
     *
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Fetch some data from API
     * @return mixed
     */
    public function execute()
    {
        $response = $this
            ->doRequest(
                static::API_REQUEST_ENDPOINT,
                ['query'=>'id=765876&appid=0b2b378346f619eb9fc39d9f7539d023']
            );
        $status = $response->getStatusCode();
        if ($status!=200) {
            return null;
        }
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();
        return json_decode($responseContent);
    }

    /**
     * Do API request with provided params
     *
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     *
     * @return Response
     */
    private function doRequest(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ): Response {
        /** @var Client $client */
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => self::API_REQUEST_URI
        ]]);
        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }
}
