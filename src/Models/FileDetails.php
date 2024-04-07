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
 * @property int $area
 * @property string $orientation
 * @property int $sizeInBytes
 * @property string $mimeType
 * @property string $format
 * @property string $colourSpace
 * @property string $publicUrl
 * @property string $permalinkUrl
 * @property string $thumbnailUrl
 * @property string $thumbnailUuid
 * @property string $cdnUrl
 * @property string $path
 * @property string $sha1Hash
 * @property string $folderUuid
 * @property string $folderPath
 * @property bool $isFavorite
 * @property Collection $meta
 * @property Collection $tags
 * @property Collection $labels
 * @property Collection $visibility
 * @property CarbonImmutable $createdAt
 * @property CarbonImmutable $modifiedAt
 */
class FileDetails extends DataTransferObject
{
    /**
     * @var string[]
     */
    protected $map = [
        'file.uuid' => 'uuid',
        'file.name' => 'name',
        'file.info.img_type' => 'format',
        'file.info.img_color_space' => 'colourSpace',
        'file.info.img_w' => 'width',
        'file.info.img_h' => 'height',
        'file.info.area' => 'area',
        'file.info.img_o' => 'orientation',
        'file.type' => 'mimeType',
        'file.size.bytes' => 'sizeInBytes',
        'file.url.public' => 'publicUrl',
        'file.url.permalink' => 'permalinkUrl',
        'file.url.cdn' => 'cdnUrl',
        'file.info.thumbnail' => 'thumbnailUrl',
        'file.info.thumbnail_uuid' => 'thumbnailUuid',
        'file.url.path' => 'path',
        'file.hash.sha1' => 'sha1Hash',
        'file.folder.uuid' => 'folderUuid',
        'file.folder.name' => 'folderPath',
        'file.is_favorite' => 'isFavorite',
        'file.created_at' => 'createdAt',
        'file.modified_at' => 'modifiedAt',
        'file.meta' => 'meta',
        'file.tags' => 'tags',
        'file.labels' => 'labels',
        'file.visibility' => 'visibility',
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
    public ?int $area = null;

    /**
     * @var string|null
     */
    public ?string $orientation = null;

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
    public ?string $thumbnailUrl = null;

    /**
     * @var string|null
     */
    public ?string $thumbnailUuid = null;

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
     * @var bool|null
     */
    public ?bool $isFavorite = null;

    /**
     * @var Collection|null
     */
    public ?Collection $meta = null;

    /**
     * @var Collection|null
     */
    public ?Collection $tags = null;

    /**
     * @var Collection|null
     */
    public ?Collection $labels = null;

    /**
     * @var Collection|null
     */
    public ?Collection $visibility = null;

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
     * @return Collection
     */
    protected function castTags($value): Collection
    {
        return new Collection($value);
    }

    /**
     * @param $value
     * @return Collection
     */
    protected function castLabels($value): Collection
    {
        return new Collection($value);
    }

    /**
     * @param $value
     * @return Collection
     */
    protected function castVisibility($value): Collection
    {
        return new Collection($value);
    }

    /**
     * @param $value
     * @return Collection
     */
    protected function castInfo($value): Collection
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
