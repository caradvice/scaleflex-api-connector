<?php

namespace Drive\ScaleflexApiConnector\Services\Scaleflex;

use Drive\ScaleflexApiConnector\Contracts\ApiClientContract;
use Drive\ScaleflexApiConnector\Models\FileDetails;
use Drive\ScaleflexApiConnector\Models\FileSearchOptions;
use Drive\ScaleflexApiConnector\Models\SearchResultFileDetails;
use Drive\ScaleflexApiConnector\Services\BaseApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class ApiClient extends BaseApiClient implements ApiClientContract
{
    /**
     * @inheritDoc
     */
    public function fileDetails(string $uuid): FileDetails
    {
        return $this->fileDetailsAsync($uuid)->wait();
    }

    /**
     * @inheritDoc
     */
    public function fileDetailsAsync(string $uuid): PromiseInterface
    {
        return $this->getAsync("files/{$uuid}", ['headers' => ['Content-Type' => 'application/json']])
            ->then(fn (ResponseInterface $response) => FileDetails::make(json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR)));
    }

    /**
     * @inheritDoc
     * @throws \JsonException
     */
    public function fileUpload($file, string $fileName = null, array $meta = [], string $folder = '/', bool $overwrite = false): FileDetails
    {
        return $this->fileUploadAsync($file, $fileName, $meta, $folder, $overwrite)->wait();
    }

    /**
     * @inheritDoc
     */
    public function fileUploadAsync($file, string $fileName = null, array $meta = [], string $folder = '/', bool $overwrite = false): PromiseInterface
    {
        $query = ['folder' => $folder];
        $body = [
            [
                'name'     => 'file',
                'filename' => $fileName ?? null,
                'contents' => is_resource($file) ? $file : Utils::tryFopen($file, 'r'),
            ],
            [
                'name'     => 'meta',
                'contents' => json_encode($meta, JSON_THROW_ON_ERROR),
            ],
        ];

        if($overwrite) {

            $query['obfuscate'] = 'KEEP_ORIGINAL_NAME';
        }

        return $this->postAsync(
            'files',
            [
                'multipart' => $body,
                'query'     => $query,
            ]
        )->then(fn (ResponseInterface $response) => FileDetails::make(json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR)));
    }

    /**
     * @inheritDoc
     */
    public function remoteUpload(array $files, string $folder = '/', bool $overwrite = false): FileDetails
    {
        return $this->remoteUploadAsync($files, $folder, $overwrite)->wait();
    }

    /**
     * @inheritDoc
     */
    public function remoteUploadAsync(array $files, string $folder = '/', bool $overwrite = false): PromiseInterface
    {
        $query = ['folder' => $folder];

        if($overwrite) {

            $query['obfuscate'] = 'KEEP_ORIGINAL_NAME';
        }

        return $this->postAsync('files', ['json' => ['files_urls' => $files], 'query' => $query])
            ->then(fn (ResponseInterface $response) => FileDetails::make(json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR)));
    }

    /**
     * @inheritDoc
     */
    public function base64Upload($file, ?string $fileName = null, array $meta = [], string $folder = '/', bool $overwrite = false): FileDetails
    {
        return $this->base64UploadAsync($file, $fileName, $meta, $folder, $overwrite)->wait();
    }

    /**
     * @inheritDoc
     */
    public function base64UploadAsync($file, ?string $fileName = null, array $meta = [], string $folder = '/', bool $overwrite = false): PromiseInterface
    {
        $query = ['folder' => $folder];

        if($overwrite) {

            $query['obfuscate'] = 'KEEP_ORIGINAL_NAME';
        }

        $body = [
            'postactions' => 'decode_base64',
            'data'        => base64_encode(is_resource($file) ? Utils::tryGetContents($file) : Utils::tryGetContents(Utils::tryFopen($file, 'r'))),
            'meta'        => $meta,
        ];

        if($fileName) {

            $body['name'] = $fileName;
        }

        return $this->postAsync(
            'files',
            [
                'json'  => $body,
                'query' => $query,
            ]
        )->then(fn (ResponseInterface $response) => FileDetails::make(json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR)));
    }

    /**
     * @inheritDoc
     */
    public function search(FileSearchOptions $options): Collection
    {
        return $this->searchAsync($options)->wait();
    }

    /**
     * @inheritDoc
     */
    public function searchAsync(FileSearchOptions $options): PromiseInterface
    {
        return $this->client->getAsync('files', ['query' => Query::build($options->toParameterArray(), false)])
            ->then(
                function (ResponseInterface $search) {

                    $results = new Collection(json_decode($search->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR));
                    $results->put('files', (new Collection($results->get('files', collect())))->mapInto(SearchResultFileDetails::class));

                    return $results;
                }
            );
    }
}
