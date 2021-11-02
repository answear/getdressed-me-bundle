<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Service;

use Answear\GetdressedMeBundle\Exception\ServiceUnavailable;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;

class Client
{
    private ConfigProvider $configProvider;

    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    public function request(string $endpoint, ?ClientInterface $client = null): ResponseInterface
    {
        try {
            $client = $client ?? new \GuzzleHttp\Client(
                [
                    RequestOptions::TIMEOUT => $this->configProvider->getRequestTimeout(),
                    RequestOptions::CONNECT_TIMEOUT => $this->configProvider->getConnectionTimeout(),
                    RequestOptions::HTTP_ERRORS => false,
                ]
            );

            $options = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->configProvider->getBearerToken(),
                    'Accept' => 'application/json',
                ],
            ];

            return $client->request(
                Request::METHOD_GET,
                sprintf('%s/%s', $this->configProvider->getApiUrl(), $endpoint),
                $options
            );
        } catch (GuzzleException $e) {
            throw new ServiceUnavailable($e->getMessage(), $e->getCode(), $e);
        }
    }
}
