<?php

namespace Drive\ScaleflexApiConnector\Models;

use Drive\ScaleflexApiConnector\Enums\ImageMimeType;
use Drive\ScaleflexApiConnector\Enums\LanguageAbbreviation;
use Drive\ScaleflexApiConnector\Enums\LogicalOperator;
use Drive\ScaleflexApiConnector\Enums\Orientation;
use Drive\ScaleflexApiConnector\Enums\Resolution;
use Drive\ScaleflexApiConnector\Enums\SortField;
use Drive\ScaleflexApiConnector\Enums\SortOrder;
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
     * @var array<string, string>
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
     * @var SortField
     */
    protected SortField $sortField;

    /**
     * @var SortOrder
     */
    protected SortOrder $sortOrder = SortOrder::ASC;

    /**
     * @var array<string, string>
     */
    protected array $format = ['select' => 'human', 'labels' => 'json_full', 'tags' => 'json_full'];

    /**
     * @var LogicalOperator
     */
    protected LogicalOperator $labelsOperator;

    /**
     * @var string[]
     */
    protected array $labels;

    /**
     * @var LanguageAbbreviation
     */
    protected LanguageAbbreviation $variant;

    /**
     * @var ImageMimeType|ImageMimeType[]|array{key-of<ImageMimeType>|value-of<ImageMimeType>}
     */
    protected ImageMimeType|array $mimetypes;

    /**
     * @var Resolution|Resolution[]|array{key-of<Resolution>|value-of<Resolution>}
     */
    protected Resolution|array $resolution;

    /**
     * @var Orientation|Orientation[]|array{key-of<Orientation>|value-of<Orientation>}
     */
    protected Orientation|array $orientation;

    /**
     * @var int[]
     */
    protected array $size;

    /**
     * @var string[]
     */
    protected array $tags;

    /**
     * @var string
     */
    protected string $folder;

    /**
     * @param  string|null  $fuzzySearch
     * @param  string|null  $folder
     * @param  bool  $recursive
     */
    public function __construct(string $fuzzySearch = null, string $folder = null, bool $recursive = true)
    {
        $fuzzySearch ? $this->fuzzySearch($fuzzySearch) : null;
        $folder ? $this->folder($folder) : null;
        $this->recursive($recursive);
    }

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
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param  string[]  $tags
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
     * @param  int  $maxFileSize  Maximum file size in mega bytes
     * @param  int  $minFileSize  Minimum file size in mega bytes
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
     * @return Orientation|Orientation[]|array{value-of<Orientation>}
     */
    public function getOrientation(): Orientation|array
    {
        return $this->orientation;
    }

    /**
     * @param  Orientation|Orientation[]|array{key-of<Orientation>|value-of<Orientation>}  $orientation
     * @return $this
     */
    public function orientation(Orientation|array $orientation): FileSearchOptions
    {
        !is_array($orientation) ?: $this->checkEnumArray($orientation, Orientation::class);

        $this->orientation = $orientation;
        return $this;
    }

    /**
     * @return Resolution|Resolution[]|array{key-of<Resolution>|value-of<Resolution>}
     */
    public function getResolution(): Resolution|array
    {
        return $this->resolution;
    }

    /**
     * @param  Resolution|Resolution[]|array{key-of<Resolution>|value-of<Resolution>}  $resolution
     * @return $this
     */
    public function resolution(Resolution|array $resolution): FileSearchOptions
    {
        !is_array($resolution) ?: $this->checkEnumArray($resolution, Resolution::class);

        $this->resolution = $resolution;
        return $this;
    }

    /**
     * @return ImageMimeType|ImageMimeType[]|array{key-of<ImageMimeType>|value-of<ImageMimeType>}
     */
    public function getMimeTypes(): ImageMimeType|array
    {
        return $this->mimetypes;
    }

    /**
     * @param  ImageMimeType|ImageMimeType[]|array{key-of<ImageMimeType>|value-of<ImageMimeType>}  $mimeTypes
     * @return $this
     */
    public function mimeTypes(ImageMimeType|array $mimeTypes): FileSearchOptions
    {
        !is_array($mimeTypes) ?: $this->checkEnumArray($mimeTypes, ImageMimeType::class);

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
     * @param  LanguageAbbreviation|value-of<LanguageAbbreviation>  $variant
     * @return $this
     */
    public function variant(LanguageAbbreviation|string $variant): FileSearchOptions
    {
        $variant = is_string($variant) ? LanguageAbbreviation::from($variant) : $variant;

        $this->variant = $variant;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @param  string[]  $labels
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
     * @param  LogicalOperator|value-of<LogicalOperator>  $labelsOperator
     * @return $this
     */
    public function labelsOperator(LogicalOperator|string $labelsOperator): FileSearchOptions
    {
        $labelsOperator = is_string($labelsOperator) ? LogicalOperator::from(strtoupper($labelsOperator)) : $labelsOperator;

        $this->labelsOperator = $labelsOperator;
        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getFormat(): array
    {
        return $this->format;
    }

    /**
     * @param  array<string, string>  $format
     * @return $this
     */
    public function format(array $format): FileSearchOptions
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return SortField
     */
    public function getSortField(): SortField
    {
        return $this->sortField;
    }

    /**
     * @return SortOrder
     */
    public function getSortOrder(): SortOrder
    {
        return $this->sortOrder;
    }

    /**
     * @param  SortField|value-of<SortField>  $field
     * @param  SortOrder|value-of<SortOrder>  $order
     * @return $this
     */
    public function sort(SortField|string $field, SortOrder|string $order = SortOrder::ASC): FileSearchOptions
    {
        $field = is_string($field) ? SortField::from($field) : $field;
        $order = is_string($order) ? SortOrder::from($order) : $order;

        $this->sortField = $field;
        $this->sortOrder = $order;

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
     * @return array<string, string>
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * @param  array<string, string>  $meta
     * @return $this
     */
    public function meta(array $meta): FileSearchOptions
    {
        $this->meta = $meta;
        return $this;
    }

    /**
     * @return array<int, mixed>|array{
     *     fuzzySearch: string,
     *     meta: array<string, string>,
     *     recursive: bool,
     *     limit: int,
     *     offset: int,
     *     sortField: SortField,
     *     sortOrder: SortOrder,
     *     format: array<string, string>,
     *     labelsOperator: LogicalOperator,
     *     labels: string[],
     *     variant: LanguageAbbreviation,
     *     mimetypes: ImageMimeType|ImageMimeType[]|array{value-of<ImageMimeType>},
     *     resolution: Resolution|Resolution[]|array{value-of<Resolution>},
     *     orientation: Orientation|Orientation[]|array{value-of<Orientation>},
     *     size: int[],
     *     tags: string[],
     *     folder: string,
     * }
     */
    public function toArray(): array
    {
        $reflection = new ReflectionClass($this);

        return collect($reflection->getProperties())->map(fn (ReflectionProperty $property) => [$property->getName() => $this->{$property->getName()} ?? null])->collapse()->toArray();
    }

    /**
     * @return array<string, string>
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
                $parameterKeyFunction = 'to' . strtoupper($propertyName) . 'ParameterKey';
                $properties[method_exists($this, $parameterKeyFunction) ? $this->$parameterKeyFunction($propertyName) : $this->toParameterKey($propertyName)] = method_exists($this, $parameterValueFunction) ? $this->$parameterValueFunction(
                    $propertyValue
                ) : $this->toParameterValue($propertyValue);
            }
        }

        $q = collect([$properties['meta'] ?? null, $properties['tags'] ?? null, $properties['fuzzySearch'] ?? null])->filter()->implode('+');

        return collect(['q' => filled($q) ? $q : null, ...$properties])->filter()->except(['fuzzy_search', 'meta', 'tag', 'sort_field', 'sort_order'])->toArray();
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
     * @param  array<string, string>  $meta
     * @return string
     */
    protected function toMetaParameterValue(array $meta): string
    {
        array_walk($meta, static fn (&$item, $key) => $item = "\"{$key}\":\"{$item}\"");

        return implode('+', $meta);
    }

    /**
     * @param  string[]  $tags
     * @return string
     */
    protected function toTagsParameterValue(array $tags): string
    {
        array_walk($tags, static fn (&$item) => $item = "\"#{$item}\"");

        return implode('+', $tags);
    }

    /**
     * @param  int[]  $fileSize
     * @return string
     */
    protected function toSizeParameterValue(array $fileSize): string
    {
        return "{$fileSize[0]}..{$fileSize[1]}";
    }

    /**
     * @param  string  $key
     * @return string
     */
    protected function toMetaParameterKey(string $key): string
    {
        return 'meta';
    }

    /**
     * @param  string  $key
     * @return string
     */
    protected function toSortFieldParameterKey(string $key): string
    {
        return 'sort';
    }

    /**
     * @param  SortField  $sortField
     * @return string
     */
    protected function toSortFieldParameterValue(SortField $sortField): string
    {
        return "{$sortField->value}:{$this->sortOrder->value}";
    }

    /**
     * @param  \BackedEnum|string|array<int, mixed>|array<string|int, mixed>  $value
     * @return string
     */
    protected function toParameterValue(\BackedEnum|array|string $value): string
    {
        if(is_array($value)) {

            if(array_is_list($value)) {


                array_walk($value, fn (&$item, $key) => $item = $this->toParameterValue($item));
                $separator = ',';
            } else {

                array_walk($value, fn (&$item, string|int $key) => $item = $key . ':' . $this->toParameterValue($item));
                $separator = '+';
            }

            $value = implode($separator, $value);
        } elseif($value instanceof \BackedEnum) {

            $value = $value->value;
        }

        return (string) $value;
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
            ->lower();
    }

    /**
     * @param  array<int, string|\BackedEnum>  $array
     * @param  class-string  $enumClass
     * @return void
     */
    protected function checkEnumArray(array $array, string $enumClass): void
    {
        foreach($array as $enum) {

            if(is_string($enum)) {

                $enumClass::tryFrom($enum) ?? throw new \InvalidArgumentException("\"{$enum}\" is not a valid image mime type");
            } elseif(!$enum instanceof $enumClass) {

                throw new \InvalidArgumentException("Invalid {$enumClass} provided");
            }
        }
    }
}
