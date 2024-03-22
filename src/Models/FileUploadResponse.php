<?php

namespace Drive\ScaleflexApiConnector\Models;

use Carbon\CarbonImmutable;
use DragonCode\SimpleDataTransferObject\DataTransferObject;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property string $uuid
 * @property string $name
 * @property int $height
 * @property int $width
 * @property int $sizeInBytes
 * @property string $mimeType
 * @property string $format
 * @property string $colourSpace
 * @property string $publicUrl
 * @property string $permalinkUrl
 * @property string $cdnUrl
 * @property string $path
 * @property string $sha1Hash
 * @property string $folderUuid
 * @property string $folderPath
 * @property Collection $meta
 * @property CarbonImmutable $createdAt
 * @property CarbonImmutable $modifiedAt
 */
class FileUploadResponse extends DataTransferObject
{
    /**
     * @var string[]
     */
    protected $map = [
        'info.img_type' => 'format',
        'info.img_color_space' => 'colourSpace',
        'info.img_w' => 'width',
        'info.img_h' => 'height',
        'type' => 'mimeType',
        'size.bytes' => 'sizeInBytes',
        'url.public' => 'publicUrl',
        'url.permalink' => 'permalinkUrl',
        'url.cdn' => 'cdnUrl',
        'url.path' => 'path',
        'hash.sha1' => 'sha1Hash',
        'folder.uuid' => 'folderUuid',
        'folder.name' => 'folderPath',
        'created_at' => 'createdAt',
        'modified_at' => 'modifiedAt',
    ];

    /**
     * @var string|null
     */
    public ?string $uuid = null;

    /**
     * @var string|null
     */
    public ?string $name = null;

    /**
     * @var int|null
     */
    public ?int $height = null;

    /**
     * @var int|null
     */
    public ?int $width = null;

    /**
     * @var int|null
     */
    public ?int $sizeInBytes = null;

    /**
     * @var string|null
     */
    public ?string $mimeType = null;

    /**
     * @var string|null
     */
    public ?string $format = null;

    /**
     * @var string|null
     */
    public ?string $colourSpace = null;

    /**
     * @var string|null
     */
    public ?string $publicUrl = null;

    /**
     * @var string|null
     */
    public ?string $permalinkUrl = null;

    /**
     * @var string|null
     */
    public ?string $cdnUrl = null;

    /**
     * @var string|null
     */
    public ?string $path = null;

    /**
     * @var string|null
     */
    public ?string $sha1Hash = null;

    /**
     * @var string|null
     */
    public ?string $folderUuid = null;

    /**
     * @var string|null
     */
    public ?string $folderPath = null;

    /**
     * @var Collection|null
     */
    public ?Collection $meta = null;

    /**
     * @var CarbonImmutable|null
     */
    public ?CarbonImmutable $createdAt = null;

    /**
     * @var CarbonImmutable|null
     */
    public ?CarbonImmutable $modifiedAt = null;

    /**
     * @param $value
     * @return string
     */
    protected function castFormat($value): string
    {
        return Str::lower($value);
    }

    /**
     * @param $value
     * @return Collection
     */
    protected function castMeta($value): Collection
    {
        return new Collection($value);
    }

    /**
     * @param $value
     * @return CarbonImmutable
     */
    protected function castCreatedAt($value): CarbonImmutable
    {
        return CarbonImmutable::parse($value);
    }

    /**
     * @param $value
     * @return CarbonImmutable
     */
    protected function castModifiedAt($value): CarbonImmutable
    {
        return CarbonImmutable::parse($value);
    }
}
