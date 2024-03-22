<?php

namespace Drive\ScaleflexApiConnector\Contracts;

use Drive\ScaleflexApiConnector\Models\FileUploadResponse;
use GuzzleHttp\Promise\PromiseInterface;

interface ApiClientContract
{
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
