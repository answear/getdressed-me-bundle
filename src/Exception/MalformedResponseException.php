<?php

declare(strict_types=1);

namespace Answear\GetdressedMeBundle\Exception;

use Answear\GetdressedMeBundle\Request\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MalformedResponseException extends \RuntimeException
{
    private ResponseInterface $response;
    private RequestInterface $request;

    public function __construct(string $message, ResponseInterface $response, RequestInterface $request, \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);

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
