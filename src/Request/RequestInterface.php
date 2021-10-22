<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Request;

interface RequestInterface
{
    public function toArray(): array;
}
