<?php

return [
    'base_url' => env('API_BASE_URL'),
    'authorization' => 'Basic ' . base64_encode(env('API_USERNAME') . ':' . env('API_PASSWORD')),
];