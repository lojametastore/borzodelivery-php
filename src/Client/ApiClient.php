<?php

namespace BorzoDelivery\Client;

use BorzoDelivery\Exceptions\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class ApiClient extends Client
{
    public function request(string $method, $uri = '', array $options = []): ResponseInterface
    {
        try {
            /** @var Response $response */
            $response = parent::request($method, $uri, $options);

            if (!$response->isSuccessful())
                throw new ApiException($response);

            if ($response->hasWarnings())
                throw new ApiException($response);

            return $response;

        } catch (ClientException $e) {
            throw new ApiException(
                $e->getResponse(),
                $e->getMessage(),
                $e->getCode()
            );
        }
    }
}