<?php

namespace Drive\ScaleflexApiConnector\Facade;

use Drive\ScaleflexApiConnector\Contracts\ApiClientContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static FileUploadResponse remoteUpload(array $files, string $folder = '/')
 * @method static PromiseInterface remoteUploadAsync(array $files, string $folder = '/')
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
