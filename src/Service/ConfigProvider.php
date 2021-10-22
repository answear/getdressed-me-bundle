<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Service;

class ConfigProvider
{
    private string $apiUrl;
    private string $bearerToken;
    private string $storeId;
    private int $requestTimeout;
    private int $connectionTimeout;

    public function __construct(
        string $apiUrl,
        string $token,
        string $storeId,
        int $requestTimeout,
        int $connectionTimeout
    ) {
        $this->apiUrl = $apiUrl;
        $this->bearerToken = $token;
        $this->storeId = $storeId;
        $this->requestTimeout = $requestTimeout;
        $this->connectionTimeout = $connectionTimeout;
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function getBearerToken(): string
    {
        return $this->bearerToken;
    }

    public function getRequestTimeout(): int
    {
        return $this->requestTimeout;
    }

    public function getStoreId(): string
    {
        return $this->storeId;
    }

    public function getConnectionTimeout(): int
    {
        return $this->connectionTimeout;
    }
}
