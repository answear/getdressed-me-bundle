<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Service;

use Answear\GetdressedMeBundle\Request\GetOutfits;
use Answear\GetdressedMeBundle\Response\OutfitsResponse;

interface GetdressedMeServiceInterface
{
    public function getOutfits(GetOutfits $request): OutfitsResponse;
}
