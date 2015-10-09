<?php

namespace HOT\Bundle\CommonBundle\HttpResponse;

use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Router;

/**
 * Class ClientErrorResponseBuilder
 *
 * @package HOT\Bundle\CommonBundle\HttpResponse
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
        return $this->getServerErrorResponseBuilder()->exception(new HttpException(Codes::HTTP_FORBIDDEN));
    }

    /**
     * @return Response
     */
    public function notFound()
    {
        return $this->getServerErrorResponseBuilder()->exception(new HttpException(Codes::HTTP_NOT_FOUND));
    }

    /**
     * @param string $message
     *
     * @return Response
     */
    public function badRequest($message)
    {
        return $this->getServerErrorResponseBuilder()->exception(new HttpException(Codes::HTTP_BAD_REQUEST, $message));
    }
}