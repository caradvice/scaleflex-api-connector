<?php

namespace Drive\ScaleflexApiConnector\Facade;

use Drive\ScaleflexApiConnector\Contracts\ApiClientContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Drive\ScaleflexApiConnector\Models\FileDetails remoteUpload(array<int, array{url: string, name?: string, meta?: array<string, mixed>}> $files, string $folder = '/', bool $overwrite = false)
 * @method static \GuzzleHttp\Promise\PromiseInterface remoteUploadAsync(array<int, array{url: string, name?: string, meta?: array<string, mixed>}> $files, string $folder = '/', bool $overwrite = false)
 *
 * @see \Drive\ScaleflexApiConnector\Services\Scaleflex\ApiClient
 */
class ScaleflexApiClient extends Facade
{
    /**
     * @return class-string
     */
    protected static function getFacadeAccessor(): string
    {
        return ApiClientContract::class;
    }
}
