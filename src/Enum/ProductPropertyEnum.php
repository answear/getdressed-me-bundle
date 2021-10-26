<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Enum;

class ProductPropertyEnum
{
    public const CLIENT_PRODUCT_ID = 'clientProductId';
    public const PRODUCT_NAME = 'productName';
    public const PRODUCT_NAME_LANG = 'productNameLang';
    public const PRODUCT_PAGE_URL = 'productPageUrl';
    public const MAIN_IMAGE_URL = 'mainImageUrl';
    public const PRICE = 'price';
    public const PRICE_CURRENCY = 'priceCurrency';
    public const SALE_PRICE = 'salePrice';

    public static function getSupported(): array
    {
        $class = new \ReflectionClass(static::class);

        return $class->getConstants();
    }
}
