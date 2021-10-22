<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Response;

use Answear\GetdressedMeBundle\Enum\OutfitsResponsePropertyEnum;
use Answear\GetdressedMeBundle\ValueObject\Outfit;
use Answear\GetdressedMeBundle\ValueObject\Product;
use Webmozart\Assert\Assert;

class OutfitsResponse implements ResponseInterface
{
    /**
     * @var Outfit[]
     */
    private array $outfits = [];
    private Product $product;

    private function __construct()
    {
    }

    public static function fromArray(array $data): self
    {
        $response = new self();

        Assert::keyExists($data, OutfitsResponsePropertyEnum::OUTFITS);
        Assert::isArray($data[OutfitsResponsePropertyEnum::OUTFITS]);

        Assert::keyExists($data, OutfitsResponsePropertyEnum::PRODUCT);
        Assert::isArray($data[OutfitsResponsePropertyEnum::PRODUCT]);

        foreach ($data[OutfitsResponsePropertyEnum::OUTFITS] as $outfitRow) {
            $response->outfits[] = Outfit::fromArray($outfitRow);
        }
        $response->product = Product::fromArray($data[OutfitsResponsePropertyEnum::PRODUCT]);

        return $response;
    }

    /**
     * @return Outfit[]
     */
    public function getOutfits(): array
    {
        return $this->outfits;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
