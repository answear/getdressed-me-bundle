<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Tests\Service;

use Answear\GetdressedMeBundle\Exception\ServiceUnavailable;
use Answear\GetdressedMeBundle\Service\Client;
use Answear\GetdressedMeBundle\Service\ConfigProvider;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function sendsValidRequest(): void
    {
        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient->expects($this->once())
            ->method('request')
            ->willReturn($this->createMock(ResponseInterface::class));

        $client = $this->createClient();
        $client->request('/v1/outfits?store_id=yourstoreid&id=123', $httpClient);
    }

    /**
     * @test
     */
    public function serviceUnavailable(): void
    {
        $this->expectException(ServiceUnavailable::class);
        $this->expectExceptionMessage('some error');

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient->expects($this->once())
            ->method('request')
            ->willThrowException(new TransferException('some error'));

        $client = $this->createClient();
        $client->request('/v1/outfits?store_id=yourstoreid&id=123', $httpClient);
    }

    private function createClient(): Client
    {
        $configProvider = $this->createMock(ConfigProvider::class);
        $configProvider->expects($this->once())
            ->method('getApiUrl')
            ->willReturn('https://your-api-url.getdressed.me');
        $configProvider->expects($this->once())
            ->method('getBearerToken')
            ->willReturn('SomeToken');

        return new Client($configProvider);
    }
}
