<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Tests\Service;

use Answear\GetdressedMeBundle\Enum\ProductPropertyEnum;
use Answear\GetdressedMeBundle\Exception\BadRequestException;
use Answear\GetdressedMeBundle\Exception\MalformedResponseException;
use Answear\GetdressedMeBundle\Request\GetOutfits;
use Answear\GetdressedMeBundle\Response\OutfitsResponse;
use Answear\GetdressedMeBundle\Service\Client;
use Answear\GetdressedMeBundle\Service\ConfigProvider;
use Answear\GetdressedMeBundle\Service\GetdressedMeService;
use Answear\GetdressedMeBundle\ValueObject\Product;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\Response;

class GetdressedMeServiceTest extends TestCase
{
    /**
     * @test
     */
    public function returnsValidResponse(): void
    {
        $outfitsResponse = $this->getService()->getOutfits(new GetOutfits('123'));

        self::assertInstanceOf(OutfitsResponse::class, $outfitsResponse);

        self::assertEquals($this->getExpectedProduct(), $this->getComparisonArrayProduct($outfitsResponse->getProduct()));

        $outfits = $outfitsResponse->getOutfits();
        self::assertCount(3, $outfits);
        self::assertCount(2, $outfits[0]->getProducts());
        self::assertCount(4, $outfits[1]->getProducts());
        self::assertCount(2, $outfits[2]->getProducts());
    }

    /**
     * @test
     * @dataProvider badRequestCodesProvider
     */
    public function badRequest(int $responseCode): void
    {
        $this->expectException(BadRequestException::class);

        $this->getService($responseCode)->getOutfits(new GetOutfits('123'));
    }

    /**
     * @test
     */
    public function malformedResponse(): void
    {
        $this->expectException(MalformedResponseException::class);

        $this->getService(Response::HTTP_OK, 'not valid json')->getOutfits(new GetOutfits('123'));
    }

    private function getService(int $statusCode = 200, ?string $responseString = null): GetdressedMeService
    {
        $body = $this->createMock(StreamInterface::class);
        $body->method('getContents')
            ->willReturn($responseString ?? $this->getResponseJson());

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn($statusCode);
        $response->method('getBody')
            ->willReturn($body);

        $client = $this->createMock(Client::class);
        $client->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $configProvider = $this->createMock(ConfigProvider::class);
        $configProvider->expects($this->once())
            ->method('getStoreId')
            ->willReturn('your-store-id');

        return new GetdressedMeService($client, $configProvider);
    }

    private function getExpectedProduct(): array
    {
        return [
            ProductPropertyEnum::CLIENT_PRODUCT_ID => '18877',
            ProductPropertyEnum::PRODUCT_NAME => 'Some brand - product',
            ProductPropertyEnum::PRODUCT_NAME_LANG => 'hu',
            ProductPropertyEnum::PRODUCT_PAGE_URL => 'https://yoursite.dev/p/some-product-18877',
            ProductPropertyEnum::MAIN_IMAGE_URL => 'https://img.yoursite.dev/i/855x1290/XX-KUD03K_99X_F1.jpg?v=1552489483',
            ProductPropertyEnum::PRICE => 23990.0,
            ProductPropertyEnum::PRICE_CURRENCY => 'HUF',
            ProductPropertyEnum::SALE_PRICE => 15990.0,
        ];
    }

    private function getComparisonArrayProduct(Product $product): array
    {
        return [
            ProductPropertyEnum::CLIENT_PRODUCT_ID => $product->getClientProductId(),
            ProductPropertyEnum::PRODUCT_NAME => $product->getProductName(),
            ProductPropertyEnum::PRODUCT_NAME_LANG => $product->getProductNameLang(),
            ProductPropertyEnum::PRODUCT_PAGE_URL => $product->getProductPageUrl(),
            ProductPropertyEnum::MAIN_IMAGE_URL => $product->getMainImageUrl(),
            ProductPropertyEnum::PRICE => $product->getPrice(),
            ProductPropertyEnum::PRICE_CURRENCY => $product->getPriceCurrency(),
            ProductPropertyEnum::SALE_PRICE => $product->getSalePrice(),
        ];
    }

    public function getResponseJson(): string
    {
        $jsonFile = __DIR__ . '/../DataFixtures/getdressedme.json';

        return file_get_contents($jsonFile);
    }

    public function badRequestCodesProvider(): iterable
    {
        yield [Response::HTTP_NOT_FOUND];
        yield [Response::HTTP_BAD_REQUEST];
        yield [Response::HTTP_PAYMENT_REQUIRED];
    }
}
