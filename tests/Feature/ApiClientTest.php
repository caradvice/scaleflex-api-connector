<?php

it(
    'gets file details synchronously',
    function () {

        $response = loadFixture('scaleflex-file-details', 'response');

        $baseApiClient = $this->mock('overload:' . \GuzzleHttp\Client::class);
        $baseApiClient->shouldReceive('getAsync')
            ->once()
            ->andReturn(new \GuzzleHttp\Promise\FulfilledPromise(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response))));

        /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
        $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
        $upload = $apiClient->fileDetails("a02e2968-9378-59bb-85a1-fa56d8d50000");

        expect($upload)
            ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Models\FileDetails::class)
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
    'gets file details asynchronously',
    function () {

        $response = loadFixture('scaleflex-file-details', 'response');

        $baseApiClient = $this->mock('overload:' . \GuzzleHttp\Client::class);
        $baseApiClient->shouldReceive('getAsync')
            ->once()
            ->andReturn(new \GuzzleHttp\Promise\FulfilledPromise(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response))));

        /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
        $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
        $upload = $apiClient->fileDetailsAsync("a02e2968-9378-59bb-85a1-fa56d8d50000");

        expect($upload)
            ->toBeInstanceOf(\GuzzleHttp\Promise\PromiseInterface::class);
    }
);

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
        $upload = $apiClient->fileUpload($file, null, ['test' => 123], '/test');

        expect($upload)
            ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Models\FileDetails::class)
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
        'path'     => realpath(__DIR__ . '/../../storage/tests/sky.jpeg'),
        'resource' => \GuzzleHttp\Psr7\Utils::tryFopen(__DIR__ . '/../../storage/tests/sky.jpeg', 'r'),
        'stream'   => \GuzzleHttp\Psr7\Utils::streamFor(__DIR__ . '/../../storage/tests/sky.jpeg'),
    ]
);

it(
    'uploads a file asynchronously',
    function ($file) {

        $response = loadFixture('scaleflex-remote-file-upload', 'response');

        $baseApiClient = $this->mock('overload:' . \GuzzleHttp\Client::class);
        $baseApiClient->shouldReceive('requestAsync')
            ->once()
            ->andReturn(new \GuzzleHttp\Promise\FulfilledPromise(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response, JSON_THROW_ON_ERROR))));

        /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
        $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
        $upload = $apiClient->fileUploadAsync($file, null, ['test' => 123], '/test', true);

        expect($upload)
            ->toBeInstanceOf(\GuzzleHttp\Promise\PromiseInterface::class);
    }
)->with(
    [
        'path'     => realpath(__DIR__ . '/../../storage/tests/sky.jpeg'),
        'resource' => \GuzzleHttp\Psr7\Utils::tryFopen(__DIR__ . '/../../storage/tests/sky.jpeg', 'r'),
        'stream'   => \GuzzleHttp\Psr7\Utils::streamFor(__DIR__ . '/../../storage/tests/sky.jpeg'),
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
            ->andReturn(new \GuzzleHttp\Promise\FulfilledPromise(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response, JSON_THROW_ON_ERROR))));

        /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
        $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
        $upload = $apiClient->remoteUpload($input['files_urls'], '/test', true);

        expect($upload)
            ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Models\FileDetails::class)
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
            ->andReturn(new \GuzzleHttp\Promise\FulfilledPromise(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response, JSON_THROW_ON_ERROR))));

        /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
        $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
        $upload = $apiClient->remoteUploadAsync($input['files_urls'], '/test');

        expect($upload)
            ->toBeInstanceOf(\GuzzleHttp\Promise\PromiseInterface::class);
    }
);

it(
    'uploads a base64 encoded file synchronously',
    function ($file) {

        $response = loadFixture('scaleflex-remote-file-upload', 'response');

        $baseApiClient = $this->mock('overload:' . \GuzzleHttp\Client::class);
        $baseApiClient->shouldReceive('requestAsync')
            ->once()
            ->andReturn(new \GuzzleHttp\Promise\FulfilledPromise(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response, JSON_THROW_ON_ERROR))));

        /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
        $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
        $upload = $apiClient->base64Upload($file, 'sky', ['test' => 123], '/test', true);

        expect($upload)
            ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Models\FileDetails::class)
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
        'path'     => realpath(__DIR__ . '/../../storage/tests/sky.jpeg'),
        'resource' => \GuzzleHttp\Psr7\Utils::tryFopen(__DIR__ . '/../../storage/tests/sky.jpeg', 'r'),
        'stream'   => \GuzzleHttp\Psr7\Utils::streamFor(__DIR__ . '/../../storage/tests/sky.jpeg'),
    ]
);

it('searches files synchronously', function () {

    $response = loadFixture('scaleflex-file-search', 'response');

    $baseApiClient = $this->mock('overload:' . \GuzzleHttp\Client::class);
    $baseApiClient->shouldReceive('getAsync')
        ->once()
        ->andReturn(new \GuzzleHttp\Promise\FulfilledPromise(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response, JSON_THROW_ON_ERROR))));

    /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
    $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);

    $searchOptions = new \Drive\ScaleflexApiConnector\Models\FileSearchOptions('sky', '/test', false);
    $search = $apiClient->search($searchOptions);

    expect($search)
        ->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($search->get('status'))
        ->toBeString()
        ->toEqual('success')
        ->and($search->get('files'))
        ->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->toHaveLength(1)
        ->and($search->get('files', collect())->first())
        ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Models\FileDetails::class)
        ->and($search->get('files', collect())->first()->uuid)
        ->toBeString()
        ->toEqual($response['files'][0]['uuid'])
        ->and($search->get('files', collect())->first()->name)
        ->toBeString()
        ->toEqual($response['files'][0]['name'])
        ->and($search->get('files', collect())->first()->createdAt)
        ->toBeInstanceOf(\Carbon\CarbonImmutable::class)
    ;
});
