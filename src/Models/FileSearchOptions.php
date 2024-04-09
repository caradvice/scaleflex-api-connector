<?php

namespace Drive\ScaleflexApiConnector\Models;

use Drive\ScaleflexApiConnector\Enums\ImageMimeTypes;
use Drive\ScaleflexApiConnector\Enums\LanguageAbbreviation;
use Drive\ScaleflexApiConnector\Enums\LogicalOperator;
use Drive\ScaleflexApiConnector\Enums\Orientations;
use Drive\ScaleflexApiConnector\Enums\Resolutions;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionProperty;

class FileSearchOptions implements Arrayable
{
    /**
     * @var string
     */
    protected string $fuzzySearch;

    /**
     * @var array
     */
    protected array $meta;

    /**
     * @var bool
     */
    protected bool $recursive = true;

    /**
     * @var int
     */
    protected int $limit;

    /**
     * @var int
     */
    protected int $offset;

    /**
     * @var array
     */
    protected array $sort;

    /**
     * @var array|string[]
     */
    protected array $format = ['select' => 'human', 'labels' => 'json_full', 'tags' => 'json_full'];

    /**
     * @var LogicalOperator
     */
    protected LogicalOperator $labelsOperator;

    /**
     * @var array
     */
    protected array $labels;

    /**
     * @var LanguageAbbreviation
     */
    protected LanguageAbbreviation $variant;

    /**
     * @var ImageMimeTypes|array<ImageMimeTypes>
     */
    protected ImageMimeTypes|array $mimetypes;

    /**
     * @var Resolutions|array<Resolutions>
     */
    protected Resolutions|array $resolution;

    /**
     * @var Orientations|array<Orientations>
     */
    protected Orientations|array $orientation;

    /**
     * @var int[]
     */
    protected array $size;

    /**
     * @var array
     */
    protected array $tags;

    /**
     * @var string
     */
    protected string $folder;

    /**
     * @return string
     */
    public function getFolder(): string
    {
        return $this->folder;
    }

    /**
     * @param  string  $folder
     * @return $this
     */
    public function folder(string $folder): FileSearchOptions
    {
        $this->folder = $folder;
        return $this;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param  array  $tags
     * @return $this
     */
    public function tags(array $tags): FileSearchOptions
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getFileSize(): array
    {
        return $this->size;
    }

    /**
     * @param  int  $maxFileSize Maximum file size in mega bytes
     * @param  int  $minFileSize Minimum file size in mega bytes
     * @return $this
     */
    public function fileSize(int $maxFileSize, int $minFileSize = 0): FileSearchOptions
    {
        if($minFileSize > $maxFileSize) {

            throw new \InvalidArgumentException('Minimum file size cannot be greater than maximum file size');
        }

        $this->size = [$minFileSize, $maxFileSize];
        return $this;
    }

    /**
     * @return Orientations
     */
    public function getOrientation(): Orientations
    {
        return $this->orientation;
    }

    /**
     * @param  Orientations|array<Orientations>  $orientation
     * @return $this
     */
    public function orientation(Orientations|array $orientation): FileSearchOptions
    {
        $this->orientation = $orientation;
        return $this;
    }

    /**
     * @return Resolutions
     */
    public function getResolution(): Resolutions
    {
        return $this->resolution;
    }

    /**
     * @param  Resolutions|array<Resolutions>  $resolution
     * @return $this
     */
    public function resolution(Resolutions|array $resolution): FileSearchOptions
    {
        $this->resolution = $resolution;
        return $this;
    }

    /**
     * @return ImageMimeTypes
     */
    public function getMimeTypes(): ImageMimeTypes
    {
        return $this->mimetypes;
    }

    /**
     * @param  ImageMimeTypes|array<ImageMimeTypes>  $mimeTypes
     * @return $this
     */
    public function mimeTypes(ImageMimeTypes|array $mimeTypes): FileSearchOptions
    {
        $this->mimetypes = $mimeTypes;
        return $this;
    }

    /**
     * @return LanguageAbbreviation
     */
    public function getVariant(): LanguageAbbreviation
    {
        return $this->variant;
    }

    /**
     * @param  LanguageAbbreviation  $variant
     * @return $this
     */
    public function variant(LanguageAbbreviation $variant): FileSearchOptions
    {
        $this->variant = $variant;
        return $this;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @param  array  $labels
     * @return $this
     */
    public function labels(array $labels): FileSearchOptions
    {
        $this->labels = $labels;
        return $this;
    }

    /**
     * @return LogicalOperator
     */
    public function getLabelsOperator(): LogicalOperator
    {
        return $this->labelsOperator;
    }

    /**
     * @param  LogicalOperator  $labelsOperator
     * @return $this
     */
    public function labelsOperator(LogicalOperator $labelsOperator): FileSearchOptions
    {
        $this->labelsOperator = $labelsOperator;
        return $this;
    }

    /**
     * @return array|string[]
     */
    public function getFormat(): array
    {
        return $this->format;
    }

    /**
     * @param  array  $format
     * @return $this
     */
    public function format(array $format): FileSearchOptions
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return array
     */
    public function getSort(): array
    {
        return $this->sort;
    }

    /**
     * @param  array  $sort
     * @return $this
     */
    public function sort(array $sort): FileSearchOptions
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param  int  $offset
     * @return $this
     */
    public function offset(int $offset): FileSearchOptions
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param  int  $limit
     * @return $this
     */
    public function limit(int $limit): FileSearchOptions
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return bool
     */
    public function getRecursive(): bool
    {
        return $this->recursive;
    }

    /**
     * @param  bool  $recursive
     * @return $this
     */
    public function recursive(bool $recursive): FileSearchOptions
    {
        $this->recursive = $recursive;
        return $this;
    }

    /**
     * @return string
     */
    public function getFuzzySearch(): string
    {
        return $this->fuzzySearch;
    }

    /**
     * @param  string  $fuzzySearch
     * @return $this
     */
    public function fuzzySearch(string $fuzzySearch): FileSearchOptions
    {
        $this->fuzzySearch = $fuzzySearch;
        return $this;
    }

    /**
     * @return array
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * @param  array  $meta
     * @return $this
     */
    public function meta(array $meta): FileSearchOptions
    {
        $this->meta = $meta;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $reflection = new ReflectionClass($this);

        return collect($reflection->getProperties())->map(fn(ReflectionProperty $property) => [$property->getName() => $this->{$property->getName()} ?? null])->collapse()->toArray();
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function toParameterArray(): array
    {
        $class = new ReflectionClass($this);
        $properties = [];

        foreach($class->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED) as $property) {
            $propertyName = $property->getName();

            if(isset($this->$propertyName)) {

                $propertyValue = $this->$propertyName;
                $parameterValueFunction = 'to' . strtoupper($propertyName) . 'ParameterValue';
                $properties[$this->toParameterKey($propertyName)] = method_exists($this, $parameterValueFunction) ? $this->$parameterValueFunction($propertyValue) : $this->toParameterValue($propertyValue);
            }
        }

        $q = collect([$properties['meta'] ?? null, $properties['tags'] ?? null, $properties['fuzzySearch'] ?? null])->filter()->implode('+');

        return collect(['q' => $q ?? null, ...$properties])->filter()->except(['fuzzy_search', 'meta', 'tag'])->toArray();
    }

    /**
     * @param  string  $fuzzySearch
     * @return string
     */
    protected function toFuzzySearchParameterValue(string $fuzzySearch): string
    {
        return Str::wrap($fuzzySearch, '"');
    }

    /**
     * @param  array  $meta
     * @return string
     */
    protected function toMetaParameterValue(array $meta): string
    {
        array_walk($meta, static fn (&$item, $key) => $item = "\"{$key}\":\"{$item}\"");

        return implode('+', $meta);
    }

    /**
     * @param  array  $tags
     * @return string
     */
    protected function toTagsParameterValue(array $tags): string
    {
        array_walk($tags, static fn (&$item) => $item = "\"#{$item}\"");

        return implode('+', $tags);
    }

    /**
     * @param  array  $fileSize
     * @return string
     */
    protected function toSizeParameterValue(array $fileSize): string
    {
        return "{$fileSize[0]}..{$fileSize[1]}";
    }

    /**
     * @param $value
     * @return string
     */
    protected function toParameterValue($value): string
    {
        if(is_array($value)) {

            if(array_is_list($value)) {


                array_walk($value, fn (&$item, $key) => $item = $this->toParameterValue($item));
                $separator = ',';
            } else {

                array_walk($value, fn (&$item, $key) => $item = $key . ':' . $this->toParameterValue($item));
                $separator = '+';
            }

            $value = implode($separator, $value);
        } elseif($value instanceof \UnitEnum) {

            $value = $value->value;
        }

        return $value;
    }

    /**
     * @param  string  $key
     * @return string
     */
    protected function toParameterKey(string $key): string
    {
        return (string) Str::of($key)
            ->snake()
            ->singular()
            ->lower()
        ;
    }
}
