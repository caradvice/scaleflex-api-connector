<?php

use Carbon\CarbonImmutable;
use Drive\ScaleflexApiConnector\Models\FileDetails;
use Drive\ScaleflexApiConnector\Models\SearchResultFileDetails;
use Illuminate\Support\Collection;

/**
 * Collections and dates flattened so whole-model expectations stay readable.
 *
 * @return array<string, mixed>
 */
function flattenFileDetails(FileDetails $details): array
{
    return array_map(
        fn ($value) => match (true) {
            $value instanceof Collection => $value->all(),
            $value instanceof CarbonImmutable => $value->toIso8601ZuluString(),
            default => $value,
        },
        $details->toArray()
    );
}

it('maps a recorded file details response onto every property', function () {

    $details = FileDetails::make(loadFixture('scaleflex-file-details', 'response'));

    expect(flattenFileDetails($details))->toBe([
        'uuid'          => 'a02e2968-9378-59bb-85a1-fa56d8d50000',
        'name'          => 'e73048748fdcc151c2d5abfcb88f6d0b-mM3QWG9e.webp',
        'height'        => 300,
        'width'         => 200,
        'area'          => 60000,
        'orientation'   => 'PO',
        'sizeInBytes'   => 10366,
        'mimeType'      => 'image/webp',
        'format'        => 'webp',
        'colourSpace'   => 'RGB',
        'publicUrl'     => 'https://store.filerobot.com/container/test/e73048748fdcc151c2d5abfcb88f6d0b-mM3QWG9e.webp',
        'permalinkUrl'  => 'https://api.filerobot.com/container/v4/get/a02e2968-9378-59bb-85a1-fa56d8d50000',
        'cdnUrl'        => 'https://container.filerobot.com/test/e73048748fdcc151c2d5abfcb88f6d0b-mM3QWG9e.webp?vh=f7434c',
        'thumbnailUrl'  => 'https://container.filerobot.com/.internal/thumbnails/a02e2968-9378-59bb-85a1-fa56d8d50000.jpg',
        'thumbnailUuid' => 'c85d9091-819b-50f5-8a0b-79d5f0350000',
        'path'          => '/test/e73048748fdcc151c2d5abfcb88f6d0b-mM3QWG9e.webp',
        'sha1Hash'      => 'f7434c71e71f000094ec512f1b6976fb247d0fae',
        'folderUuid'    => '11481872-c424-5d92-b3c3-80721ddd5fec',
        'folderPath'    => '/test',
        'isFavorite'    => null,
        'meta'          => ['foo' => 'bar'],
        'tags'          => null,
        'labels'        => [],
        'visibility'    => [
            'value'     => 'VISIBILITY_INHERIT',
            'inherited' => 'VISIBILITY_ORGANISATION',
            'set'       => 'VISIBILITY_INHERIT',
            'actual'    => 'VISIBILITY_ORGANISATION',
        ],
        'createdAt'     => '2024-04-04T02:40:22Z',
        'modifiedAt'    => '2024-04-04T02:40:27Z',
    ]);
});

it('maps a recorded upload response, leaving absent fields null', function () {

    $details = new FileDetails(loadFixture('scaleflex-remote-file-upload', 'response'));

    expect($details->uuid)->toBe('b7ace86b-5f83-5d0a-8367-e8962e750000')
        ->and($details->publicUrl)->toBe('https://store.filerobot.com/123/test/test-image-7brqJR8K')
        ->and($details->format)->toBe('jpeg')
        ->and($details->folderPath)->toBe('/test/')
        ->and($details->area)->toBeNull()
        ->and($details->thumbnailUrl)->toBeNull()
        ->and($details->labels)->toBeNull()
        ->and($details->visibility)->toBeNull();
});

it('moves meta.tagging into tags and out of meta', function () {

    $details = FileDetails::make(loadFixture('scaleflex-file-details', 'response', 'file.meta.tagging', ['tag1', 'tag2']));

    expect($details->tags)->toBeInstanceOf(Collection::class)
        ->and($details->tags->all())->toBe(['tag1', 'tag2'])
        ->and($details->meta->all())->toBe(['foo' => 'bar']);
});

it('maps a recorded search result, taking tags from the top-level key', function () {

    $details = new SearchResultFileDetails(loadFixture('scaleflex-file-search', 'response')['files'][0]);

    expect($details->uuid)->toBe('8e2e85a8-f2ba-5c9d-a12f-7247b7f50000')
        ->and($details->name)->toBe('sky-U0wznLpH.webp')
        ->and($details->publicUrl)->toBe('https://store.filerobot.com/test/test/sky-U0wznLpH.webp')
        ->and($details->folderUuid)->toBe('e6695119-7821-5481-b389-cde0f27ad86e')
        ->and($details->tags?->all())->toBe([])
        ->and($details->createdAt?->toIso8601ZuluString())->toBe('2024-04-12T07:35:50Z');
});

it('leaves every property null when built empty', function () {

    expect((new FileDetails())->toArray())
        ->toHaveCount(26)
        ->each->toBeNull();
});

it('accepts the partial and flat shapes consumers build in their tests', function () {

    $partial = new FileDetails(['file' => ['uuid' => 'abc', 'url' => ['cdn' => 'https://cdn.example/a.jpg?vh=1']]]);
    $flat = new SearchResultFileDetails(['name' => 'a.jpg', 'folderPath' => '/a', 'width' => 1024, 'sizeInBytes' => 1]);

    expect($partial->uuid)->toBe('abc')
        ->and($partial->cdnUrl)->toBe('https://cdn.example/a.jpg?vh=1')
        ->and($partial->name)->toBeNull()
        ->and($flat->name)->toBe('a.jpg')
        ->and($flat->folderPath)->toBe('/a')
        ->and($flat->width)->toBe(1024)
        ->and($flat->sizeInBytes)->toBe(1);
});

it('lets top-level property keys override mapped values', function () {

    $details = FileDetails::make(['file' => ['uuid' => 'mapped'], 'uuid' => 'direct', 'format' => 'PNG', 'map' => []]);

    expect($details->uuid)->toBe('direct')
        ->and($details->format)->toBe('png');
});

it('serialises to json', function () {

    $details = FileDetails::make(loadFixture('scaleflex-file-details', 'response'));

    expect(json_decode($details->toJson(), true))
        ->toHaveKey('publicUrl', $details->publicUrl)
        ->toHaveKey('meta', ['foo' => 'bar']);
});
