<?php

it('should register a facade for Scaleflex API client', function () {

    expect($this->app->get(\Drive\ScaleflexApiConnector\Facade\ScaleflexApiClient::class))
        ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Facade\ScaleflexApiClient::class, 'Facade is not registered correctly.')
        ->and(\Drive\ScaleflexApiConnector\Facade\ScaleflexApiClient::getFacadeRoot())
        ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Contracts\ApiClientContract::class, 'Facade root is not an instance of ApiClientContract.')
        ->and(is_callable([\Drive\ScaleflexApiConnector\Facade\ScaleflexApiClient::class, 'remoteUpload']))
        ->toBeTrue('Facade method remoteUpload is not callable.')
        ->and(is_callable([\Drive\ScaleflexApiConnector\Facade\ScaleflexApiClient::class, 'remoteUploadAsync']))
        ->toBeTrue('Facade method remoteUploadAsync is not callable.')
    ;
});
