<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Tests\ValueObject;

use Answear\GetdressedMeBundle\Enum\ProductPropertyEnum;
use Answear\GetdressedMeBundle\ValueObject\Product;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function validObjectCreation(): void
    {
        self::assertInstanceOf(Product::class, Product::fromArray($this->getValidData()));
    }

    /**
     * @test
     * @dataProvider invalidDataProvider
     */
    public function invalidObjectCreation(array $invalidData): void
    {
        $this->expectException(InvalidArgumentException::class);

        Product::fromArray($invalidData);
    }

    public function getValidData(): array
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

    public function invalidDataProvider(): iterable
    {
        $validData = $this->getValidData();

        foreach ($validData as $key => $value) {
            $invalidData = $validData;
            unset($invalidData[$key]);

            yield $key . ' not set' => [$invalidData];
        }

        foreach ($validData as $key => $value) {
            $withEmptyStringData = $validData;
            $withEmptyStringData[$key] = '';

            yield $key . ' should not be empty or string' => [$withEmptyStringData];
        }
    }
}
