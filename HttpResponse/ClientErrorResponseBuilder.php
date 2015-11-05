<?php

namespace CuteNinja\ParabolaBundle\HttpResponse;

use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ClientErrorResponseBuilder
 *
 * @package CuteNinja\ParabolaBundle\HttpResponse
 */
class ClientErrorResponseBuilder extends AbstractResponseBuilder
{
    /**
     * @param ViewHandler $viewHandler
     */
    public function __construct(ViewHandler $viewHandler)
    {
        parent::__construct($viewHandler);
    }

    /**
     * @return Response
     */
    public function forbidden()
    {
        return $this->getServerErrorResponseBuilder()->exception(new HttpException(Response::HTTP_FORBIDDEN));
    }

    /**
     * @return Response
     */
    public function notFound()
    {
        return $this->getServerErrorResponseBuilder()->exception(new HttpException(Response::HTTP_NOT_FOUND));
    }

    /**
     * @param string $message
     *
     * @return Response
     */
    public function badRequest($message)
    {
        return $this->getServerErrorResponseBuilder()->exception(new HttpException(Response::HTTP_BAD_REQUEST, $message));
    }
}