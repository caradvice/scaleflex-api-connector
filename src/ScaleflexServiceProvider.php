<?php

namespace Drive\ScaleflexApiConnector;

use Drive\ScaleflexApiConnector\Contracts\ApiClientContract;
use Drive\ScaleflexApiConnector\Services\Scaleflex\ApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ScaleflexServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/scaleflex.php', 'scaleflex');
        $config = $this->app->make('config');

        $this->app->bind(ApiClientContract::class, ApiClient::class);
        $this->app
            ->when(ApiClient::class)
            ->needs(ClientInterface::class)
            ->give(
                function () use ($config) {
                    return new Client(
                        [
                            'base_uri' => $config->get('scaleflex.uri'),
                            'headers'  => [
                                'X-Filerobot-Key' => $config->get('scaleflex.api_key'),
                                'User-Agent'      => 'Scaleflex API Connector (https://github.com/caradvice/scaleflex-api-connector)'
                            ],
                        ]
                    );
                }
            );
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->publishes(
            [
                __DIR__ . '/../config/scaleflex.php' => config_path('scaleflex.php'),
            ],
            'config'
        );

        $this->setConfigUri();

        $this->app->singleton('scaleflex.api', function ($app) {

            return $app->make(ApiClientContract::class);
        });
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return ['scaleflex.api'];
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    protected function setConfigUri(): void
    {
        $config = $this->app->make('config');
        $config->set('scaleflex.uri', $this->transformScaleflexUri($config));
    }

    /**
     * @param  Config  $config
     * @return string
     */
    protected function transformScaleflexUri(Config $config): string
    {
        $containerId = $config->get('scaleflex.container_id');
        $uri = $config->get('scaleflex.uri');

        return str_replace('{containerId}', $containerId, $uri);
    }
}
