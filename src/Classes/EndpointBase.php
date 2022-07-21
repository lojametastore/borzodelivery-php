<?php

namespace BorzoDelivery\Classes;


use BorzoDelivery\Api\Borzo;
use BorzoDelivery\Client\ApiClient;
use BorzoDelivery\Client\Response;

abstract class EndpointBase
{
    /**
     * @var ApiClient
     */
    protected $apiClient;

    public function __construct($apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @return ApiClient
     */
    public function getApiClient(): ApiClient
    {
        return $this->apiClient;
    }

    /**
     * @param ApiClient $apiClient
     */
    public function setApiClient(ApiClient $apiClient): void
    {
        $this->apiClient = $apiClient;
    }

    protected function request(string $method, string $uri, array $options = []): Response
    {
        return $this->getApiClient()->request($method, $uri, $options);
    }
}