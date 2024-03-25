<?php

it(
    'uploads a file synchronously',
    function ($file) {

        $response = loadFixture('scaleflex-remote-file-upload', 'response');

        $baseApiClient = $this->mock('overload:' . \GuzzleHttp\Client::class);
        $baseApiClient->shouldReceive('requestAsync')
            ->once()
            ->andReturn(new \GuzzleHttp\Promise\FulfilledPromise(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response))));

        /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
        $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
        $upload = $apiClient->fileUpload($file, ['test' => 123], '/Test');

        expect($upload)
            ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Models\FileUploadResponse::class)
            ->and($upload->uuid)
            ->toBeString()
            ->toEqual($response['file']['uuid'])
            ->and($upload->createdAt)
            ->toBeInstanceOf(\Carbon\CarbonImmutable::class)
            ->and($upload->toArray())
            ->toBeArray();
    }
)->with(
    [
        'path' => realpath(__DIR__ . '/../Files/sky.jpeg'),
        'resource' => \GuzzleHttp\Psr7\Utils::tryFopen(__DIR__ . '/../Files/sky.jpeg', 'r'),
        'stream' => \GuzzleHttp\Psr7\Utils::streamFor(__DIR__ . '/../Files/sky.jpeg'),
    ]
);

it(
    'uploads a file asynchronously',
    function ($file) {

        $response = loadFixture('scaleflex-remote-file-upload', 'response');

        $baseApiClient = $this->mock('overload:' . \GuzzleHttp\Client::class);
        $baseApiClient->shouldReceive('requestAsync')
            ->once()
            ->andReturn(new \GuzzleHttp\Promise\FulfilledPromise(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response))));

        /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
        $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
        $upload = $apiClient->fileUploadAsync($file, ['test' => 123], '/Test');

        expect($upload)
            ->toBeInstanceOf(\GuzzleHttp\Promise\PromiseInterface::class);
    }
)->with(
    [
        'path' => realpath(__DIR__ . '/../Files/sky.jpeg'),
        'resource' => \GuzzleHttp\Psr7\Utils::tryFopen(__DIR__ . '/../Files/sky.jpeg', 'r'),
        'stream' => \GuzzleHttp\Psr7\Utils::streamFor(__DIR__ . '/../Files/sky.jpeg'),
    ]
);

it(
    'upload remote URLs synchronously',
    function () {

        $input = loadFixture('scaleflex-remote-file-upload', 'input');
        $response = loadFixture('scaleflex-remote-file-upload', 'response');

        $baseApiClient = $this->mock('overload:' . \GuzzleHttp\Client::class);
        $baseApiClient->shouldReceive('requestAsync')
            ->once()
            ->andReturn(new \GuzzleHttp\Promise\FulfilledPromise(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response))));

        /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
        $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
        $upload = $apiClient->remoteUpload($input['files_urls'], '/Test');

        expect($upload)
            ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Models\FileUploadResponse::class)
            ->and($upload->uuid)
            ->toBeString()
            ->toEqual($response['file']['uuid'])
            ->and($upload->createdAt)
            ->toBeInstanceOf(\Carbon\CarbonImmutable::class)
            ->and($upload->toArray())
            ->toBeArray();
    }
);

it(
    'upload remote URLs asynchronously',
    function () {

        $input = loadFixture('scaleflex-remote-file-upload', 'input');
        $response = loadFixture('scaleflex-remote-file-upload', 'response');

        $baseApiClient = $this->mock('overload:' . \GuzzleHttp\Client::class);
        $baseApiClient->shouldReceive('requestAsync')
            ->once()
            ->andReturn(new \GuzzleHttp\Promise\FulfilledPromise(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response))));

        /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
        $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
        $upload = $apiClient->remoteUploadAsync($input['files_urls'], '/Test');

        expect($upload)
            ->toBeInstanceOf(\GuzzleHttp\Promise\PromiseInterface::class);
    }
);
