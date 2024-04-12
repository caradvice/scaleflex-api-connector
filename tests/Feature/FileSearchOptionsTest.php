<?php

it(
    'can create a search options instance with all search criterias',
    function () {

        $searchOptions = (new \Drive\ScaleflexApiConnector\Models\FileSearchOptions())
            ->recursive(true)
            ->fuzzySearch('test-image')
            ->meta(['foo' => 'bar', 'baz' => 'qux'])
            ->tags(['tag1', 'tag2'])
            ->labels(['label1', 'label2', 'label3'])
            ->labelsOperator('AND')
            ->limit(10)
            ->offset(20)
            ->sort('uploaded_at', 'desc')
            ->folder('/test/images/')
            ->variant('en')
            ->mimeTypes(['image/jpeg', 'image/png'])
            ->resolution(['small', 'medium'])
            ->orientation(['LD', 'PO'])
            ->fileSize(10)
            ->format(['select' => 'human', 'labels' => 'json_full', 'tags' => 'json_full']);

        expect($searchOptions)
            ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Models\FileSearchOptions::class)
            ->and($searchOptions->getRecursive())
            ->toBeBool()
            ->toEqual(true)
            ->and($searchOptions->getFuzzySearch())
            ->toBeString()
            ->toEqual('test-image')
            ->and($searchOptions->getMeta())
            ->toBeArray()
            ->toHaveKeys(['foo', 'baz'])
            ->toContain('bar', 'qux')
            ->and($searchOptions->getTags())
            ->toBeArray()
            ->toContain('tag1', 'tag2')
            ->and($searchOptions->getLabels())
            ->toBeArray()
            ->toContain('label1', 'label2', 'label3')
            ->and($searchOptions->getLabelsOperator())
            ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Enums\LogicalOperator::class)
            ->toEqual(\Drive\ScaleflexApiConnector\Enums\LogicalOperator::AND)
            ->and($searchOptions->getLimit())
            ->toBeInt()
            ->toEqual(10)
            ->and($searchOptions->getOffset())
            ->toBeInt()
            ->toEqual(20)
            ->and($searchOptions->getSortField())
            ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Enums\SortField::class)
            ->toEqual(\Drive\ScaleflexApiConnector\Enums\SortField::UPLOADED_AT)
            ->and($searchOptions->getSortOrder())
            ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Enums\SortOrder::class)
            ->toEqual(\Drive\ScaleflexApiConnector\Enums\SortOrder::DESC)
            ->and($searchOptions->getFolder())
            ->toBeString()
            ->toEqual('/test/images/')
            ->and($searchOptions->getVariant())
            ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Enums\LanguageAbbreviation::class)
            ->toEqual(\Drive\ScaleflexApiConnector\Enums\LanguageAbbreviation::EN)
            ->and($searchOptions->getMimeTypes())
            ->toBeArray()
            ->toContainEqual('image/jpeg', 'image/png')
            ->and($searchOptions->getResolution())
            ->toBeArray()
            ->toContainEqual('small', 'medium')
            ->and($searchOptions->getOrientation())
            ->toBeArray()
            ->toContainEqual('LD', 'PO')
            ->and($searchOptions->getFileSize())
            ->toBeArray()
            ->toContainEqual(0, 10)
            ->and($searchOptions->getFormat())
            ->toBeArray()
            ->toHaveKeys(['select', 'labels', 'tags'])
            ->toContain('human', 'json_full');
    }
);

it(
    'can return an array of parametised search options',
    function () {

        $searchOptions = (new \Drive\ScaleflexApiConnector\Models\FileSearchOptions())
            ->fuzzySearch('test-image')
            ->meta(['foo' => 'bar', 'baz' => 'qux'])
            ->tags(['tag1', 'tag2'])
            ->limit(10)
            ->offset(20)
            ->sort('uploaded_at', 'desc')
            ->folder('/test/images/')
            ->variant('en')
            ->mimeTypes(['image/jpeg', 'image/png'])
            ->resolution(['small', 'medium'])
            ->orientation(['LD', 'PO'])
            ->fileSize(10);

        $params = $searchOptions->toParameterArray();

        expect($params)
            ->toBeArray()
            ->toHaveKeys(
                [
                    'q',
                    'recursive',
                    'limit',
                    'offset',
                    'sort',
                    'format',
                    'variant',
                    'mimetype',
                    'resolution',
                    'orientation',
                    'size',
                    'folder',
                ]
            )
            ->not->toHaveKeys(
                [
                    'fuzzy_search',
                    'meta',
                    'tag',
                    'sort_field',
                    'sort_order',

                ]
            )
            ->and($params['q'])
            ->toBeString()
            ->toEqual('"foo":"bar"+"baz":"qux"')
            ->and($params['recursive'])
            ->toBeString()
            ->toEqual('1')
            ->and($params['limit'])
            ->toBeString()
            ->toEqual('10')
            ->and($params['offset'])
            ->toBeString()
            ->toEqual('20')
            ->and($params['sort'])
            ->toBeString()
            ->toEqual('uploaded_at:desc')
            ->and($params['format'])
            ->toBeString()
            ->toEqual('select:human+labels:json_full+tags:json_full')
            ->and($params['variant'])
            ->toBeString()
            ->toEqual('en')
            ->and($params['mimetype'])
            ->toBeString()
            ->toEqual('image/jpeg,image/png')
            ->and($params['resolution'])
            ->toBeString()
            ->toEqual('small,medium')
            ->and($params['orientation'])
            ->toBeString()
            ->toEqual('LD,PO')
            ->and($params['size'])
            ->toBeString()
            ->toEqual('0..10')
            ->and($params['folder'])
            ->toBeString()
            ->toEqual('/test/images/');
    }
);

it('can convert search options into an array', function () {

    $searchOptions = (new \Drive\ScaleflexApiConnector\Models\FileSearchOptions())
        ->fuzzySearch('test-image')
        ->meta(['foo' => 'bar', 'baz' => 'qux'])
        ->tags(['tag1', 'tag2'])
        ->limit(10)
        ->offset(20)
        ->sort('uploaded_at', 'desc')
        ->folder('/test/images/')
        ->variant('en')
        ->mimeTypes(['image/jpeg', 'image/png'])
        ->resolution(['small', 'medium'])
        ->orientation(['LD', 'PO'])
        ->fileSize(10);

    $params = $searchOptions->toArray();

    expect($params)
        ->toBeArray()
        ->toHaveKeys(
            [
                'fuzzySearch',
                'meta',
                'tags',
                'limit',
                'offset',
                'sortField',
                'sortOrder',
                'format',
                'labelsOperator',
                'labels',
                'folder',
                'variant',
                'mimetypes',
                'resolution',
                'orientation',
                'size',
            ]
        )
        ->not->toHaveKeys(
            [
                'q',
            ]
        )
        ->and($params['fuzzySearch'])
        ->toBeString()
        ->toEqual('test-image')
        ->and($params['meta'])
        ->toBeArray()
        ->toHaveKeys(['foo', 'baz'])
        ->and($params['tags'])
        ->toBeArray()
        ->toContainEqual('tag1', 'tag2')
        ->and($params['limit'])
        ->toBeInt()
        ->toEqual(10)
        ->and($params['offset'])
        ->toBeInt()
        ->toEqual(20)
        ->and($params['sortField'])
        ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Enums\SortField::class)
        ->toEqual(\Drive\ScaleflexApiConnector\Enums\SortField::UPLOADED_AT)
        ->and($params['sortOrder'])
        ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Enums\SortOrder::class)
        ->toEqual(\Drive\ScaleflexApiConnector\Enums\SortOrder::DESC)
        ->and($params['folder'])
        ->toBeString()
        ->toEqual('/test/images/')
        ->and($params['variant'])
        ->toBeInstanceOf(\Drive\ScaleflexApiConnector\Enums\LanguageAbbreviation::class)
        ->toEqual(\Drive\ScaleflexApiConnector\Enums\LanguageAbbreviation::EN)
        ->and($params['mimetypes'])
        ->toBeArray()
        ->toContainEqual('image/jpeg', 'image/png')
        ->and($params['resolution'])
        ->toBeArray()
        ->toContainEqual('small', 'medium')
        ->and($params['orientation'])
        ->toBeArray()
        ->toContainEqual('LD', 'PO');
});

it('throws an exception when giving an invalid file size range', function () {

    $searchOptions = (new \Drive\ScaleflexApiConnector\Models\FileSearchOptions())
        ->fileSize(5, 10);

    $searchOptions->toArray();
})->throws(\InvalidArgumentException::class);

it('throws an exception when giving an invalid enum within an array', function () {

    $searchOptions = (new \Drive\ScaleflexApiConnector\Models\FileSearchOptions())
        ->orientation(['LD', 'PO', \Drive\ScaleflexApiConnector\Enums\Resolution::LARGE]);
})->throws(\InvalidArgumentException::class);
