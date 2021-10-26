<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\ValueObject;

class Outfit
{
    /**
     * @var Product[]
     */
    private array $products = [];

    private function __construct()
    {
    }

    public static function fromArray(array $data): self
    {
        $outfit = new self();

        foreach ($data as $productData) {
            $outfit->products[] = Product::fromArray($productData);
        }

        return $outfit;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}
