<?php

return [
    'uri' => 'https://api.filerobot.com/{containerId}/v5/',
    'container_id' => env('SCALEFLEX_CONTAINER_ID'),
    'api_key' => env('SCALEFLEX_API_KEY'),
    // Seconds; 0 disables the limit (Guzzle's default, which lets a hung upload block forever).
    'timeout' => (float) env('SCALEFLEX_TIMEOUT', 30),
    'connect_timeout' => (float) env('SCALEFLEX_CONNECT_TIMEOUT', 5),
];
