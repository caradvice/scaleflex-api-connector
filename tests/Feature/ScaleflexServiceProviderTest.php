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
        $config = $guzzle->getConfig();

        expect($config)
            ->toHaveKey('base_uri', $this->app->get('config')?->get('scaleflex.uri'))
            ->and($config)
            ->toHaveKey('headers')
            ->and($config['headers'])
            ->toHaveKey('Content-Type', 'application/json')
            ->toHaveKey('X-Filerobot-Key', $this->app->get('config')?->get('scaleflex.api_key'))
            ->toHaveKey('User-Agent', 'Drive/Scaleflex-Connector (https://www.drive.com.au)');
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
