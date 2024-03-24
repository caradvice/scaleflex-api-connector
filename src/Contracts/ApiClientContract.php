<?php

namespace Drive\ScaleflexApiConnector\Contracts;

use Drive\ScaleflexApiConnector\Models\FileUploadResponse;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\StreamInterface;

interface ApiClientContract
{
    /**
     * @param string|resource|StreamInterface $file File path or resource or stream
     * @param  array  $meta
     * @param  string  $folder
     * @return FileUploadResponse
     */
    public function fileUpload($file, array $meta = [], string $folder = '/'): FileUploadResponse;

    /**
     * @param string|resource|StreamInterface $file File path or resource or stream
     * @param  array  $meta
     * @param  string  $folder
     * @return FileUploadResponse
     */
    public function fileUploadAsync($file, array $meta = [], string $folder = '/'): PromiseInterface;

    /**
     * @param  list<array{url: string, name?: string, meta?: array}>  $files
     * @param  string  $folder
     * @return FileUploadResponse
     * @link https://developers.scaleflex.com/#e3b464d2-c176-418b-890c-acaaa369b521
     */
    public function remoteUpload(array $files, string $folder = '/'): FileUploadResponse;

    /**
     * @param  list<array{url: string, name?: string, meta?: array}>  $files
     * @param  string  $folder
     * @return PromiseInterface
     * @link https://developers.scaleflex.com/#e3b464d2-c176-418b-890c-acaaa369b521
     */
    public function remoteUploadAsync(array $files, string $folder = '/'): PromiseInterface;
}
