<?php

namespace BorzoDelivery\Api;

use BorzoDelivery\Client\ApiClient;
use BorzoDelivery\Client\Response;
use BorzoDelivery\Resources\OrderResource;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;

class Borzo
{
    /**
     * Login secret_auth_token
     * @var string
     */
    protected $secret_auth_token = '';

    /**
     * @var bool
     */
    protected $sandbox = true;

    /**
     * @var string
     */
    protected $test_base_uri = 'https://robotapitest-br.borzodelivery.com/api/business/1.1/';

    /**
     * @var string
     */
    protected $production_base_uri = 'https://robot-br.borzodelivery.com/api/business/1.1/';

    /**
     * @var ApiClient
     */
    protected $apiClient;

    public function __construct(string $secret_auth_token, bool $sandbox)
    {
        $this->secret_auth_token = $secret_auth_token;
        $this->sandbox = $sandbox;
    }

    protected function makeStack(): HandlerStack
    {
        $stack = HandlerStack::create();

        $stack->push(Middleware::mapResponse(function (ResponseInterface $response) {
            return new Response(
                $response->getStatusCode(),
                $response->getHeaders(),
                $response->getBody(),
                $response->getProtocolVersion(),
                $response->getReasonPhrase());
        }));

        return $stack;
    }

    public function getApiClient(): ApiClient
    {
        if (null == $this->apiClient) {
            $this->apiClient = new ApiClient([
                'base_uri' => $this->getBaseUri(),
                'handler'  => self::makeStack(),
                'headers'  => [
                    'X-DV-Auth-Token' => $this->secret_auth_token,
                    'Content-Type'    => 'application/json',
                ]
            ]);
        }

        return $this->apiClient;
    }

    protected function getBaseUri(): string
    {
        return $this->sandbox ? $this->test_base_uri : $this->production_base_uri;
    }

    /**
     * @return OrderResource
     */
    public function order(): OrderResource
    {
        return new OrderResource($this->getApiClient());
    }
}