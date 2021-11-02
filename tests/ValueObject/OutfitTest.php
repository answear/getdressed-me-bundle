<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Tests\ValueObject;

use Answear\GetdressedMeBundle\Enum\ProductPropertyEnum;
use Answear\GetdressedMeBundle\ValueObject\Outfit;
use PHPUnit\Framework\TestCase;

class OutfitTest extends TestCase
{
    /**
     * @test
     */
    public function validObjectCreation(): void
    {
        self::assertInstanceOf(Outfit::class, Outfit::fromArray($this->getValidData()));
    }

    public function getValidData(): array
    {
        return [
            [
                ProductPropertyEnum::CLIENT_PRODUCT_ID => '123',
                ProductPropertyEnum::PRODUCT_NAME => 'My product name',
                ProductPropertyEnum::PRODUCT_NAME_LANG => 'pl',
                ProductPropertyEnum::PRODUCT_PAGE_URL => 'https://my-site.local/my-product-123',
                ProductPropertyEnum::MAIN_IMAGE_URL => 'https://img.my-site.local/my-product-123.jpg',
                ProductPropertyEnum::PRICE => 123.99,
                ProductPropertyEnum::PRICE_CURRENCY => 'PLN',
                ProductPropertyEnum::SALE_PRICE => 123.99,
            ],
            [
                ProductPropertyEnum::CLIENT_PRODUCT_ID => '456',
                ProductPropertyEnum::PRODUCT_NAME => 'My second product name',
                ProductPropertyEnum::PRODUCT_NAME_LANG => 'pl',
                ProductPropertyEnum::PRODUCT_PAGE_URL => 'https://my-site.local/my-product-456',
                ProductPropertyEnum::MAIN_IMAGE_URL => 'https://img.my-site.local/my-product-456.jpg',
                ProductPropertyEnum::PRICE => 123.99,
                ProductPropertyEnum::PRICE_CURRENCY => 'PLN',
                ProductPropertyEnum::SALE_PRICE => 123.99,
            ],
        ];
    }
}
