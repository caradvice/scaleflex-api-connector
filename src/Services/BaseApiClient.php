<?php

namespace Drive\ScaleflexApiConnector\Services;

use Drive\ScaleflexApiConnector\Contracts\BaseApiClientContract;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

class BaseApiClient implements BaseApiClientContract
{
    /**
     * @var ClientInterface
     */
    protected ClientInterface $client;

    /**
     * @param  ClientInterface  $client
     */
    public function __construct(ClientInterface $client)
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
