<?php

namespace Drive\ScaleflexApiConnector\Models;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

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
class SearchResultFileDetails extends FileDetails
{
    /**
     * @var string[]
     */
    protected $map = [
        'uuid' => 'uuid',
        'name' => 'name',
        'info.img_type' => 'format',
        'info.img_color_space' => 'colourSpace',
        'info.img_w' => 'width',
        'info.img_h' => 'height',
        'info.area' => 'area',
        'info.img_o' => 'orientation',
        'type' => 'mimeType',
        'size.bytes' => 'sizeInBytes',
        'url.public' => 'publicUrl',
        'url.permalink' => 'permalinkUrl',
        'url.cdn' => 'cdnUrl',
        'info.thumbnail' => 'thumbnailUrl',
        'info.thumbnail_uuid' => 'thumbnailUuid',
        'url.path' => 'path',
        'hash.sha1' => 'sha1Hash',
        'folder.uuid' => 'folderUuid',
        'folder.name' => 'folderPath',
        'is_favorite' => 'isFavorite',
        'created_at' => 'createdAt',
        'modified_at' => 'modifiedAt',
        'meta' => 'meta',
        'meta.tagging' => 'tags',
        'labels' => 'labels',
        'visibility' => 'visibility',
    ];
}
