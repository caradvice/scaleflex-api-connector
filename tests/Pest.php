<?php

use Drive\ScaleflexApiConnector\Tests\TestCase;
use Illuminate\Support\Arr;

uses(TestCase::class)->in(__DIR__);

/**
 * @param $file
 * @param $key
 * @param $override
 * @param $value
 * @return mixed
 * @throws JsonException
 */
function loadFixture($file, $key, $override = null, $value = null)
{
    $fixture = json_decode(file_get_contents(__DIR__ . "/Fixtures/{$file}.json"), true, 512, JSON_THROW_ON_ERROR)[$key];

    if(!is_null($override)) {

        $replacement = is_array($override) ? $override : [$override => $value];

        foreach($replacement as $a => $b) {

            Arr::set($fixture, $a, $b);
        }
    }

    return $fixture;
}
