<?php

namespace Drive\ScaleflexApiConnector\Contracts;

use Drive\ScaleflexApiConnector\Models\FileDetails;
use Drive\ScaleflexApiConnector\Models\FileSearchOptions;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Collection;
use Psr\Http\Message\StreamInterface;

interface ApiClientContract
{
    /**
     * @param  string  $uuid
     * @return FileDetails
     * @link https://developers.scaleflex.com/#5a97d86a-0f37-460a-b87d-502269ed406d
     */
    public function fileDetails(string $uuid): FileDetails;

    /**
     * @param  string  $uuid
     * @return PromiseInterface
     * @link https://developers.scaleflex.com/#5a97d86a-0f37-460a-b87d-502269ed406d
     */
    public function fileDetailsAsync(string $uuid): PromiseInterface;

    /**
     * @param  string|resource|StreamInterface  $file  File path or resource or stream
     * @param  string|null  $fileName  Manually set file name or inherit uploaded file name if null
     * @param  array<string, string>  $meta
     * @param  string[]  $tags
     * @param  string  $folder
     * @param  bool  $overwrite  Overwrite file a destination if it already exists
     * @return FileDetails
     */
    public function fileUpload($file, string $fileName = null, array $meta = [], array $tags = [], string $folder = '/', bool $overwrite = false): FileDetails;

    /**
     * @param  string|resource|StreamInterface  $file  File path or resource or stream
     * @param  string|null  $fileName  Manually set file name or inherit uploaded file name if null
     * @param  array<string, string>  $meta
     * @param  string[]  $tags
     * @param  string  $folder
     * @param  bool  $overwrite  Overwrite file a destination if it already exists
     * @return PromiseInterface
     */
    public function fileUploadAsync($file, string $fileName = null, array $meta = [], array $tags = [], string $folder = '/', bool $overwrite = false): PromiseInterface;

    /**
     * @param  array{int, array{url: string, name?: string, meta?: array<string, string>}}  $files
     * @param  string  $folder
     * @param  bool  $overwrite  Overwrite file a destination if it already exists
     * @return FileDetails
     * @link https://developers.scaleflex.com/#e3b464d2-c176-418b-890c-acaaa369b521
     */
    public function remoteUpload(array $files, string $folder = '/', bool $overwrite = false): FileDetails;

    /**
     * @param  array{int, array{url: string, name?: string, meta?: array<string, string>}}  $files
     * @param  string  $folder
     * @param  bool  $overwrite  Overwrite file a destination if it already exists
     * @return PromiseInterface
     * @link https://developers.scaleflex.com/#e3b464d2-c176-418b-890c-acaaa369b521
     */
    public function remoteUploadAsync(array $files, string $folder = '/', bool $overwrite = false): PromiseInterface;

    /**
     * @param  string|resource|StreamInterface  $file  File path or resource or stream
     * @param  string|null  $fileName
     * @param  array<string, string>  $meta
     * @param  string[]  $tags
     * @param  string  $folder
     * @param  bool  $overwrite  Overwrite file a destination if it already exists
     * @return FileDetails
     * @link https://developers.scaleflex.com/#75975094-04fa-402d-8125-ade2618881b9
     */
    public function base64Upload($file, ?string $fileName = null, array $meta = [], array $tags = [], string $folder = '/', bool $overwrite = false): FileDetails;

    /**
     * @param  string|resource|StreamInterface  $file  File path or resource or stream
     * @param  string|null  $fileName
     * @param  array<string, string>  $meta
     * @param  string[]  $tags
     * @param  string  $folder
     * @param  bool  $overwrite  Overwrite file a destination if it already exists
     * @return PromiseInterface
     * @link https://developers.scaleflex.com/#75975094-04fa-402d-8125-ade2618881b9
     */
    public function base64UploadAsync($file, ?string $fileName = null, array $meta = [], array $tags = [], string $folder = '/', bool $overwrite = false): PromiseInterface;

    /**
     * @param  FileSearchOptions  $options
     * @return Collection
     */
    public function search(FileSearchOptions $options): Collection;

    /**
     * @param  FileSearchOptions  $options
     * @return PromiseInterface
     */
    public function searchAsync(FileSearchOptions $options): PromiseInterface;
}
