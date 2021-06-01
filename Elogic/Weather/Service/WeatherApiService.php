<?php
declare(strict_types=1);

namespace Elogic\Weather\Service;

use Elogic\Weather\Helper\Data;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class WeatherApiService
 * @package Elogic\Weather\Service
 */
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
    private ResponseFactory $responseFactory;

    /**
     * @var ClientFactory
     */
    private ClientFactory $clientFactory;

    /**
     * @var Data
     */
    private Data $helperData;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * WeatherApiService constructor
     *
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     * @param Data $helperData
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        Data $helperData,
        SerializerInterface $serializer
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->helperData = $helperData;
        $this->serializer = $serializer;
    }

    /**
     * Fetch some data from API
     * @return mixed
     */
    public function execute()
    {
        $param =
            [
                'id' => $this->helperData->getGeneralConfig('city_id'),
                'appid' => $this->helperData->getGeneralConfig('api_key'),
                'units' => $this->helperData->getGeneralConfig('units')
            ];
        $dataAttributes = array_map(function ($value, $key) {
            return "{$key}={$value}";
        }, array_values($param), array_keys($param));
        $params = implode('&', $dataAttributes);
        $response = $this
            ->doRequest(
                static::API_REQUEST_ENDPOINT,
                ['query'=>$params]
            );
        $status = $response->getStatusCode();
        if ($status!=200) {
            return null;
        }
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();
        return $this->serializer->unserialize($responseContent);
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
