<?php

namespace Drive\ScaleflexApiConnector\Contracts;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

interface BaseApiClientContract
{
    /**
     * @param  string  $uri
     * @param  array  $options
     * @return ResponseInterface
     */
    public function post(string $uri, array $options = []): ResponseInterface;

    /**
     * @param  string  $uri
     * @param  array  $options
     * @return PromiseInterface
     */
    public function postAsync(string $uri, array $options = []): PromiseInterface;
}
