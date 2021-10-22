<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Request;

class GetOutfits implements RequestInterface
{
    private string $productId;

    public function __construct(string $productId)
    {
        $this->productId = $productId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function toArray(): array
    {
        return ['productId' => $this->productId];
    }
}
