<?php

namespace BorzoDelivery\Client;


class Response extends \GuzzleHttp\Psr7\Response
{
    protected $contents;

    /**
     * @return array|mixed|\StdClass
     */
    public function getContent()
    {
        if (null === $this->contents) {
            $this->contents = $this->getBody()->getContents();
        }

        if ($this->contents) {
            $response = json_decode($this->contents);
        } else {
            $response = [$this->contents];
        }

        return $response;
    }

    /**
     * Check response is_successful
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return property_exists($this->getContent(), 'is_successful')
            && boolval($this->getContent()->is_successful);
    }

    /**
     * Check response has warnings
     * @return bool
     */
    public function hasWarnings(): bool
    {
        $content = $this->getContent();
        return property_exists($content, 'warnings')
            && $content->warnings;
    }
}