<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Service;

use Answear\GetdressedMeBundle\Exception\BadRequestException;
use Answear\GetdressedMeBundle\Exception\MalformedResponseException;
use Answear\GetdressedMeBundle\Request\GetOutfits;
use Answear\GetdressedMeBundle\Response\OutfitsResponse;
use Symfony\Component\HttpFoundation\Response;

class GetdressedMeService implements GetdressedMeServiceInterface
{
    private Client $client;
    private ConfigProvider $configProvider;

    public function __construct(Client $client, ConfigProvider $configProvider)
    {
        $this->client = $client;
        $this->configProvider = $configProvider;
    }

    public function getOutfits(GetOutfits $request): OutfitsResponse
    {
        $endpoint = \sprintf('/v1/outfits?store_id=%s&id=%s', $this->configProvider->getStoreId(), $request->getProductId());

        $response = $this->client->request($endpoint);

        $badRequestStatuses = [Response::HTTP_NOT_FOUND, Response::HTTP_BAD_REQUEST, Response::HTTP_PAYMENT_REQUIRED];
        if (\in_array($response->getStatusCode(), $badRequestStatuses, true)) {
            throw new BadRequestException($response, $request);
        }

        try {
            $decoded = \json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            return OutfitsResponse::fromArray($decoded);
        } catch (\Throwable $throwable) {
            throw new MalformedResponseException($throwable->getMessage(), $response, $request, $throwable);
        }
    }
}
