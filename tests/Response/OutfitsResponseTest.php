<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Tests\Response;

use Answear\GetdressedMeBundle\Enum\OutfitsResponsePropertyEnum;
use Answear\GetdressedMeBundle\Enum\ProductPropertyEnum;
use Answear\GetdressedMeBundle\Response\OutfitsResponse;
use Answear\GetdressedMeBundle\ValueObject\Product;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class OutfitsResponseTest extends TestCase
{
    /**
     * @test
     */
    public function validObjectCreation(): void
    {
        $outfitsResponse = OutfitsResponse::fromArray($this->getValidData());
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
     * @dataProvider invalidDataProvider
     */
    public function invalidObjectCreation(array $invalidData): void
    {
        $this->expectException(InvalidArgumentException::class);

        OutfitsResponse::fromArray($invalidData);
    }

    public function getValidData(): array
    {
        $jsonFile = __DIR__ . '/../DataFixtures/getdressedme.json';

        return \json_decode(file_get_contents($jsonFile), true, 512, JSON_THROW_ON_ERROR);
    }

    public function invalidDataProvider(): iterable
    {
        yield 'no outfits key' => [
            [OutfitsResponsePropertyEnum::PRODUCT => $this->getProductData()],
        ];

        yield 'outfits not array' => [
            [
                OutfitsResponsePropertyEnum::PRODUCT => $this->getProductData(),
                OutfitsResponsePropertyEnum::OUTFITS => 'invalid type',
            ],
        ];

        yield 'no product key' => [
            [OutfitsResponsePropertyEnum::OUTFITS => []],
        ];

        yield 'product not array' => [
            [
                OutfitsResponsePropertyEnum::PRODUCT => 'invalid type',
                OutfitsResponsePropertyEnum::OUTFITS => [],
            ],
        ];
    }

    private function getProductData(): array
    {
        return [
            ProductPropertyEnum::CLIENT_PRODUCT_ID => '123',
            ProductPropertyEnum::PRODUCT_NAME => 'My product name',
            ProductPropertyEnum::PRODUCT_NAME_LANG => 'pl',
            ProductPropertyEnum::PRODUCT_PAGE_URL => 'https://my-site.local/my-product-123',
            ProductPropertyEnum::MAIN_IMAGE_URL => 'https://img.my-site.local/my-product-123.jpg',
            ProductPropertyEnum::PRICE => 123.99,
            ProductPropertyEnum::PRICE_CURRENCY => 'PLN',
            ProductPropertyEnum::SALE_PRICE => 123.99,
        ];
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
}
