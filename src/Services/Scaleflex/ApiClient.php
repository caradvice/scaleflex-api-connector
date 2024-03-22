<?php

namespace Drive\ScaleflexApiConnector\Services\Scaleflex;

use Drive\ScaleflexApiConnector\Contracts\ApiClientContract;
use Drive\ScaleflexApiConnector\Models\FileUploadResponse;
use Drive\ScaleflexApiConnector\Services\BaseApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class ApiClient extends BaseApiClient implements ApiClientContract
{
    /**
     * @inheritDoc
     * @throws JsonException
     */
    public function remoteUpload(array $files, string $folder = '/'): FileUploadResponse
    {
        $upload = $this->post('files', ['json' => ['files_urls' => $files], 'query' => ['folder' => $folder]]);

        return FileUploadResponse::make(json_decode($upload->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR)['file']);
    }

    /**
     * @inheritDoc
     */
    public function remoteUploadAsync(array $files, string $folder = '/'): PromiseInterface
    {
        return $this->postAsync('files', ['json' => ['files_urls' => $files], 'query' => ['folder' => $folder]])
            ->then(fn (ResponseInterface $response) => FileUploadResponse::make(json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR)['file']));
    }
}
