<?php

namespace Drive\ScaleflexApiConnector\Contracts;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

interface BaseApiClientContract
{
    /**
     * @param  string  $uri
     * @param  array<string, mixed>  $options
     * @return ResponseInterface
     */
    public function get(string $uri, array $options = []): ResponseInterface;

    /**
     * @param  string  $uri
     * @param  array<string, mixed>  $options
     * @return PromiseInterface
     */
    public function getAsync(string $uri, array $options = []): PromiseInterface;

    /**
     * @param  string  $uri
     * @param  array<string, mixed>  $options
     * @return ResponseInterface
     */
    public function post(string $uri, array $options = []): ResponseInterface;

    /**
     * @param  string  $uri
     * @param  array<string, mixed>  $options
     * @return PromiseInterface
     */
    public function postAsync(string $uri, array $options = []): PromiseInterface;
}
