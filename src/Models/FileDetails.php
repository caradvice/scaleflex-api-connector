<?php

namespace Drive\ScaleflexApiConnector\Models;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionProperty;

/**
 * Hydration mirrors dragon-code/simple-dto 2.8, which this class used to extend: dot-notation `$map`
 * entries are applied first, then top-level keys matching a property name, each through its cast method.
 *
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
 *
 * @phpstan-consistent-constructor
 *
 * @implements Arrayable<string, mixed>
 */
class FileDetails implements Arrayable
{
    /**
     * @var string[]
     */
    protected $map = [
        'file.uuid'                 => 'uuid',
        'file.name'                 => 'name',
        'file.info.img_type'        => 'format',
        'file.info.img_color_space' => 'colourSpace',
        'file.info.img_w'           => 'width',
        'file.info.img_h'           => 'height',
        'file.info.area'            => 'area',
        'file.info.img_o'           => 'orientation',
        'file.type'                 => 'mimeType',
        'file.size.bytes'           => 'sizeInBytes',
        'file.url.public'           => 'publicUrl',
        'file.url.permalink'        => 'permalinkUrl',
        'file.url.cdn'              => 'cdnUrl',
        'file.info.thumbnail'       => 'thumbnailUrl',
        'file.info.thumbnail_uuid'  => 'thumbnailUuid',
        'file.url.path'             => 'path',
        'file.hash.sha1'            => 'sha1Hash',
        'file.folder.uuid'          => 'folderUuid',
        'file.folder.name'          => 'folderPath',
        'file.is_favorite'          => 'isFavorite',
        'file.created_at'           => 'createdAt',
        'file.modified_at'          => 'modifiedAt',
        'file.meta'                 => 'meta',
        'file.meta.tagging'         => 'tags',
        'file.labels'               => 'labels',
        'file.visibility'           => 'visibility',
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
     * @param  array<array-key, mixed>  $items
     */
    public function __construct(array $items = [])
    {
        $this->merge($items);
    }

    /**
     * @param  array<array-key, mixed>  $items
     */
    public static function make(array $items = []): static
    {
        return new static($items);
    }

    /**
     * @param  array<array-key, mixed>  $items
     */
    public static function fromArray(array $items): static
    {
        return new static($items);
    }

    public static function fromJson(string $json): static
    {
        return new static(json_decode($json, true));
    }

    public static function fromObject(object $object): static
    {
        return new static(method_exists($object, 'toArray') ? $object->toArray() : get_object_vars($object));
    }

    /**
     * @param  array<array-key, mixed>  $items
     * @return $this
     */
    public function merge(array $items): static
    {
        foreach ($this->map as $from => $to) {
            if (Arr::has($items, $from)) {
                $this->setValue($to, Arr::get($items, $from));
            }
        }

        foreach ($items as $key => $value) {
            $this->setValue((string) $key, $value);
        }

        return $this;
    }

    public function get(string $key): mixed
    {
        if (! $this->isAllowed($key)) {
            throw new \Error('Cannot access private property ' . static::class . '::$' . $key);
        }

        return $this->{$key};
    }

    /**
     * @return $this
     */
    public function set(string $key, mixed $value): static
    {
        if (! $this->isAllowed($key)) {
            throw new \Error('Cannot access private property ' . static::class . '::$' . $key);
        }

        $this->{$key} = $value;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];

        foreach ((new ReflectionClass($this))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $result[$property->getName()] = $this->{$property->getName()};
        }

        return $result;
    }

    public function toJson(int $flags = JSON_UNESCAPED_UNICODE): string
    {
        return (string) json_encode($this->toArray(), $flags);
    }

    protected function setValue(string $key, mixed $value): void
    {
        if (! $this->isAllowed($key)) {
            return;
        }

        $cast = Str::camel('cast_' . trim($key));

        $this->set($key, method_exists($this, $cast) ? $this->{$cast}($value) : $value);
    }

    protected function isAllowed(string $key): bool
    {
        if (Str::lower($key) === 'map' || ! property_exists($this, $key)) {
            return false;
        }

        $property = new ReflectionProperty($this, $key);

        return ! $property->isStatic() && ! $property->isPrivate();
    }

    /**
     * @param  string  $value
     * @return string
     */
    protected function castFormat(string $value): string
    {
        return Str::lower($value);
    }

    /**
     * @param  array<string, string|int>  $value
     * @return Collection
     */
    protected function castMeta(?array $value): Collection
    {
        return (new Collection($value))->forget('tagging');
    }

    /**
     * @param  string[]  $value
     * @return Collection
     */
    protected function castTags(?array $value): Collection
    {
        return new Collection($value);
    }

    /**
     * @param  string[]  $value
     * @return Collection
     */
    protected function castLabels(?array $value): Collection
    {
        return new Collection($value);
    }

    /**
     * @param  array<string, string>  $value
     * @return Collection
     */
    protected function castVisibility(?array $value): Collection
    {
        return new Collection($value);
    }

    /**
     * @param  array<string, string|int>  $value
     * @return Collection
     */
    protected function castInfo(?array $value): Collection
    {
        return new Collection($value);
    }

    /**
     * @param  string  $value
     * @return CarbonImmutable
     */
    protected function castCreatedAt(string $value): CarbonImmutable
    {
        return CarbonImmutable::parse($value);
    }

    /**
     * @param  string  $value
     * @return CarbonImmutable
     */
    protected function castModifiedAt(string $value): CarbonImmutable
    {
        return CarbonImmutable::parse($value);
    }
}
