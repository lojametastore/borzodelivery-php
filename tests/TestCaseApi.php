<?php

namespace Tests;

use BorzoDelivery\Api\Borzo;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class TestCaseApi extends TestCase
{
    /**
     * @var boolean
     */
    protected $sandbox = true;

    /**
     * @var string
     */
    protected $secret_auth_token;

    /**
     * @var Borzo
     */
    protected $sdk;

    /**
     * @var Generator
     */
    protected $faker;

    protected function setUp(): void
    {
        $this->secret_auth_token = getenv('SECRET_AUTH_TOKEN');
        $this->sandbox = boolval(getenv('SANDBOX'));
    }

    protected function getSdk(): Borzo
    {
        $this->sdk = new Borzo($this->secret_auth_token, $this->sandbox);
        return $this->sdk;
    }

    protected function faker(): Generator
    {
        if (null === $this->faker)
            $this->faker = Factory::create('pt_BR');

        return $this->faker;
    }
}