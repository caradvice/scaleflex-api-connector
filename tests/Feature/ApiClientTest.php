<?php

it('uploads a file from a path', function() {

    $filePath = realpath(__DIR__ . '/../Files/sky.jpeg');
    $response = loadFixture('scaleflex-remote-file-upload', 'response');

    $baseApiClient = $this->mock('overload:' . \Drive\ScaleflexApiConnector\Services\BaseApiClient::class);
    $baseApiClient->shouldReceive('postAsync')
        ->once()
        ->with('files', [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => $filePath,
                ],
                [
                    'name'     => 'meta',
                    'contents' => ['test' => 123],
                ],
            ],
            'query'     => ['folder' => '/Test'],
        ])->andReturn(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response)));

    /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
    $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);

    $upload = $apiClient->fileUpload($filePath, ['test' => 123], '/Test');

    expect($upload)
        ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Models\FileUploadResponse::class)
        ->and($upload->uuid)
        ->toBeString()
        ->toEqual($response['file']['uuid'])
        ->and($upload->createdAt)
        ->toBeInstanceOf(\Carbon\CarbonImmutable::class)
        ->and($upload->toArray())
        ->toBeArray()
    ;
});

it('upload remote URLs synchronously', function () {

    $input = loadFixture('scaleflex-remote-file-upload', 'input');
    $response = loadFixture('scaleflex-remote-file-upload', 'response');

    $baseApiClient = $this->mock('overload:' . \Drive\ScaleflexApiConnector\Services\BaseApiClient::class);
    $baseApiClient->shouldReceive('postAsync')
        ->once()
        ->with('files', [
            'json' => $input,
            'query' => ['folder' => '/Test'],
        ])->andReturn(new \GuzzleHttp\Psr7\Response(200, [], json_encode($response)));

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
        ->toBeArray()
    ;
});

it('upload remote URLs asynchronously', function () {

    $input = loadFixture('scaleflex-remote-file-upload', 'input');

    $baseApiClient = $this->mock('overload:' . \Drive\ScaleflexApiConnector\Services\BaseApiClient::class);
    $baseApiClient->shouldReceive('postAsync')
        ->once()
        ->with('files', [
            'json' => $input,
            'query' => ['folder' => '/Test'],
        ])->andReturn(new \GuzzleHttp\Promise\Promise());

    /** @var \Drive\ScaleflexApiConnector\Contracts\ApiClientContract $apiClient */
    $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
    $upload = $apiClient->remoteUploadAsync($input['files_urls'], '/Test');

    expect($upload)
        ->toBeInstanceOf(\GuzzleHttp\Promise\PromiseInterface::class);
});
