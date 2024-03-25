<?php

namespace Drive\ScaleflexApiConnector\Services;

use Drive\ScaleflexApiConnector\Contracts\BaseApiClientContract;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

class BaseApiClient implements BaseApiClientContract
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @param  Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function post(string $uri, array $options = []): ResponseInterface
    {
        return $this->postAsync($uri, $options)->wait();
    }

    /**
     * @inheritDoc
     */
    public function postAsync(string $uri, array $options = []): PromiseInterface
    {
        return $this->client->requestAsync('POST', $uri, $options);
    }
}
