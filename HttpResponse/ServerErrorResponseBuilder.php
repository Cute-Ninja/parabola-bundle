<?php

namespace CuteNinja\ParabolaBundle\HttpResponse;

use Exception;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ServerErrorResponseBuilder
 *
 * @package CuteNinja\ParabolaBundle\HttpResponse
 */
class ServerErrorResponseBuilder extends AbstractResponseBuilder
{
    /**
     * @param Exception $e
     *
     * @return Response
     */
    public function exception(Exception $e)
    {
        if ($e instanceof HttpException) {
            $e = new Exception($e->getMessage(), $e->getStatusCode());
        }
        $code    = $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR;
        $message = $e->getMessage() ?: null;

        return $this->handle(View::create($message, $code));
    }

    /**
     * @return Response
     */
    public function notImplemented()
    {
        return $this->getServerErrorResponseBuilder()->exception(new HttpException(Response::HTTP_NOT_IMPLEMENTED));
    }
}