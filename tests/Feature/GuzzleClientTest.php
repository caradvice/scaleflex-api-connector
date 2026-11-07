<?php

use Drive\ScaleflexApiConnector\Models\FileDetails;
use Drive\ScaleflexApiConnector\Services\Scaleflex\ApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

// The other client tests overload Guzzle with Mockery; this one runs the real client (7.x or 8.x) on a mock handler.
it('uploads and reads file details through a real Guzzle client', function () {

    $history = [];
    $stack = HandlerStack::create(new MockHandler([
        new Response(200, [], json_encode(loadFixture('scaleflex-remote-file-upload', 'response'), JSON_THROW_ON_ERROR)),
        new Response(200, [], json_encode(loadFixture('scaleflex-file-details', 'response'), JSON_THROW_ON_ERROR)),
    ]));
    $stack->push(Middleware::history($history));

    $apiClient = new ApiClient(new Client([
        'handler'         => $stack,
        'base_uri'        => 'https://api.filerobot.com/123/v5/',
        'timeout'         => 30.0,
        'connect_timeout' => 5.0,
    ]));

    $upload = $apiClient->fileUpload(__DIR__ . '/../../storage/tests/sky.jpeg', 'sky.jpeg', ['foo' => 'bar'], ['tag1'], '/test', true);
    $details = $apiClient->fileDetails('a02e2968-9378-59bb-85a1-fa56d8d50000');

    expect($upload)->toBeInstanceOf(FileDetails::class)
        ->and($upload->uuid)->toBe('b7ace86b-5f83-5d0a-8367-e8962e750000')
        ->and($details->publicUrl)->toBe('https://store.filerobot.com/container/test/e73048748fdcc151c2d5abfcb88f6d0b-mM3QWG9e.webp')
        ->and((string) $history[0]['request']->getUri())->toBe('https://api.filerobot.com/123/v5/files?folder=%2Ftest&obfuscate=KEEP_ORIGINAL_NAME')
        ->and((string) $history[1]['request']->getUri())->toBe('https://api.filerobot.com/123/v5/files/a02e2968-9378-59bb-85a1-fa56d8d50000')
        ->and($history[0]['options'])->toHaveKey('timeout', 30.0)->toHaveKey('connect_timeout', 5.0);
});
