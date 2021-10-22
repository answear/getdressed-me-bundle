<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\ValueObject;

use Answear\GetdressedMeBundle\Enum\ProductPropertyEnum;
use Webmozart\Assert\Assert;

class Product
{
    private string $clientProductId;
    private string $productName;
    private string $productNameLang;
    private string $productPageUrl;
    private string $mainImageUrl;
    private float $price;
    private string $priceCurrency;
    private float $salePrice;

    private function __construct()
    {
    }

    public static function fromArray(array $data): self
    {
        $product = new self();

        self::validate($data);

        $product->clientProductId = $data[ProductPropertyEnum::CLIENT_PRODUCT_ID];
        $product->productName = $data[ProductPropertyEnum::PRODUCT_NAME];
        $product->productNameLang = $data[ProductPropertyEnum::PRODUCT_NAME_LANG];
        $product->productPageUrl = $data[ProductPropertyEnum::PRODUCT_PAGE_URL];
        $product->mainImageUrl = $data[ProductPropertyEnum::MAIN_IMAGE_URL];
        $product->price = $data[ProductPropertyEnum::PRICE];
        $product->priceCurrency = $data[ProductPropertyEnum::PRICE_CURRENCY];
        $product->salePrice = $data[ProductPropertyEnum::SALE_PRICE];

        return $product;
    }

    private static function validate(array $data): void
    {
        foreach (ProductPropertyEnum::getSupported() as $requiredKey) {
            Assert::keyExists($data, $requiredKey, \sprintf('Required key %s does not exist in product data', $requiredKey));
        }

        Assert::stringNotEmpty($data[ProductPropertyEnum::CLIENT_PRODUCT_ID]);
        Assert::stringNotEmpty($data[ProductPropertyEnum::PRODUCT_NAME]);
        Assert::stringNotEmpty($data[ProductPropertyEnum::PRODUCT_NAME_LANG]);
        Assert::stringNotEmpty($data[ProductPropertyEnum::PRODUCT_PAGE_URL]);
        Assert::stringNotEmpty($data[ProductPropertyEnum::MAIN_IMAGE_URL]);
        Assert::float($data[ProductPropertyEnum::PRICE]);
        Assert::stringNotEmpty($data[ProductPropertyEnum::PRICE_CURRENCY]);
        Assert::float($data[ProductPropertyEnum::SALE_PRICE]);
    }

    public function getClientProductId(): string
    {
        return $this->clientProductId;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getProductNameLang(): string
    {
        return $this->productNameLang;
    }

    public function getProductPageUrl(): string
    {
        return $this->productPageUrl;
    }

    public function getMainImageUrl(): string
    {
        return $this->mainImageUrl;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPriceCurrency(): string
    {
        return $this->priceCurrency;
    }

    public function getSalePrice(): float
    {
        return $this->salePrice;
    }
}
