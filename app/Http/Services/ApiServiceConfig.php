<?php

namespace App\Http\Services;

class ApiServiceConfig
{
    private $baseUrl;
    private $authorization;

    public function __construct(?string $baseUrl, string $authorization)
    {
        $this->baseUrl = $baseUrl;
        $this->authorization = $authorization;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getAuthorization(): string
    {
        return $this->authorization;
    }
}