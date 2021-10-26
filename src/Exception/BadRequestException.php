<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Exception;

use Answear\GetdressedMeBundle\Request\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class BadRequestException extends \RuntimeException
{
    private ResponseInterface $response;
    private RequestInterface $request;

    public function __construct(ResponseInterface $response, RequestInterface $request)
    {
        parent::__construct('Bad request.');

        $this->response = $response;
        $this->request = $request;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
