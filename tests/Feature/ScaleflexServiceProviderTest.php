<?php

it(
    'registers Scaleflex service provider correctly',
    function () {

        expect($this->app->providerIsLoaded(Drive\ScaleflexApiConnector\ScaleflexServiceProvider::class))
            ->toBeTrue('Scaleflex service provider is not loaded correctly.')
            ->and($this->app->get('config')?->get('scaleflex'))
            ->not->toBeNull('Scaleflex config is not loaded correctly.');
    }
);

it(
    'binds Scaleflex API client correctly',
    function () {

        $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);

        expect($apiClient)
            ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Services\Scaleflex\ApiClient::class)
            ->and($this->app->getProvider(\Drive\ScaleflexApiConnector\ScaleflexServiceProvider::class)?->provides())
            ->toContain('scaleflex.api');
    }
);

it(
    'binds Scaleflex config correctly',
    function () {

        $config = $this->app->get('config')?->get('scaleflex');

        expect($config)
            ->toHaveKeys(['uri', 'container_id', 'api_key']);
    }
);

it(
    'publishes Scaleflex config file',
    function () {

        $provider = $this->app->getProvider(\Drive\ScaleflexApiConnector\ScaleflexServiceProvider::class);
        $publishes = $provider::$publishes[\Drive\ScaleflexApiConnector\ScaleflexServiceProvider::class];

        expect(array_key_first($publishes))
            ->toEndWith('/../config/scaleflex.php', 'Scaleflex config file is not published correctly.');
    }
);

it(
    'sets base_uri and headers in Scaleflex API client',
    function () {

        $apiClient = $this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
        $reflection = new ReflectionClass($this->app->make(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class));
        $clientProperty = $reflection->getProperty('client');
        $clientProperty->setAccessible(true);

        /** @var GuzzleHttp\Client $guzzle */
        $guzzle = $clientProperty->getValue($apiClient);
        $guzzleReflection = new ReflectionClass($guzzle);
        $configProperty = $guzzleReflection->getProperty('config');
        $configProperty->setAccessible(true);
        $config = $configProperty->getValue($guzzle);

        expect($config)
            ->toHaveKey('base_uri', $this->app->get('config')?->get('scaleflex.uri'))
            ->and($config)
            ->toHaveKey('headers')
            ->and($config['headers'])
            ->toHaveKey('X-Filerobot-Key', $this->app->get('config')?->get('scaleflex.api_key'))
            ->toHaveKey('User-Agent', \Drive\ScaleflexApiConnector\ScaleflexServiceProvider::$userAgent);
    }
);

it(
    'replaces {containerId} in Scaleflex URI with container_id from config',
    function () {

        $scaleflexConfig = $this->app->get('config')?->get('scaleflex');

        expect($scaleflexConfig)
            ->not->toBeNull('Scaleflex config is not loaded correctly.')
            ->and($scaleflexConfig['uri'])
            ->not->toContain('{containerId}', 'Container ID is not replaced in Scaleflex URI.')
        ;
    }
);

/**
 * @return array<string, mixed>
 */
function scaleflexGuzzleConfig(): array
{
    $apiClient = app(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class);
    $guzzle = (new ReflectionProperty($apiClient, 'client'))->getValue($apiClient);

    return (new ReflectionProperty($guzzle, 'config'))->getValue($guzzle);
}

it(
    'applies default connect and total timeouts',
    function () {

        expect(scaleflexGuzzleConfig())
            ->toHaveKey('connect_timeout', 5.0)
            ->toHaveKey('timeout', 30.0);
    }
);

it(
    'applies configured timeouts',
    function () {

        config(['scaleflex.connect_timeout' => 2, 'scaleflex.timeout' => 120]);

        expect(scaleflexGuzzleConfig())
            ->toHaveKey('connect_timeout', 2)
            ->toHaveKey('timeout', 120);
    }
);

it(
    'falls back to default timeouts when the config predates them',
    function () {

        config(['scaleflex' => ['uri' => 'https://api.filerobot.com/123/v5/', 'container_id' => '123', 'api_key' => '123']]);

        expect(scaleflexGuzzleConfig())
            ->toHaveKey('connect_timeout', 5)
            ->toHaveKey('timeout', 30);
    }
);
