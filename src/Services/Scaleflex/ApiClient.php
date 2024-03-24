<?php

namespace Drive\ScaleflexApiConnector\Services\Scaleflex;

use Drive\ScaleflexApiConnector\Contracts\ApiClientContract;
use Drive\ScaleflexApiConnector\Models\FileUploadResponse;
use Drive\ScaleflexApiConnector\Services\BaseApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Utils;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class ApiClient extends BaseApiClient implements ApiClientContract
{
    /**
     * @inheritDoc
     */
    public function fileUpload($file, array $meta = [], string $folder = '/'): FileUploadResponse
    {
        return $this->fileUploadAsync($file, $meta, $folder)->wait();
    }

    /**
     * @inheritDoc
     */
    public function fileUploadAsync($file, array $meta = [], string $folder = '/'): PromiseInterface
    {
        return $this->postAsync(
            'files', [
                       'multipart' => [
                           [
                               'name'     => 'file',
                               'contents' => is_resource($file) ? $file : Utils::tryFopen($file, 'r'),
                           ],
                           [
                               'name'     => 'meta',
                               'contents' => json_encode($meta, JSON_THROW_ON_ERROR),
                           ],
                       ],
                       'query'     => ['folder' => $folder],
                   ]
        )->then(fn(ResponseInterface $response) => FileUploadResponse::make(json_decode($response->getBody()->getContents(), TRUE, 512, JSON_THROW_ON_ERROR)['file']));
    }

    /**
     * @inheritDoc
     * @throws JsonException
     */
    public function remoteUpload(array $files, string $folder = '/'): FileUploadResponse
    {
        return $this->remoteUploadAsync($files, $folder)->wait();
    }

    /**
     * @inheritDoc
     */
    public function remoteUploadAsync(array $files, string $folder = '/'): PromiseInterface
    {
        return $this->postAsync('files', ['json' => ['files_urls' => $files], 'query' => ['folder' => $folder]])
            ->then(fn(ResponseInterface $response) => FileUploadResponse::make(json_decode($response->getBody()->getContents(), TRUE, 512, JSON_THROW_ON_ERROR)['file']));
    }
}
