<?php

namespace CuteNinja\CommonBundle\HttpResponse;

use Exception;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Router;

/**
 * Class ServerErrorResponseBuilder
 *
 * @package CuteNinja\CommonBundle\HttpResponse
 */
class ServerErrorResponseBuilder extends AbstractResponseBuilder
{
    /**
     * @param ViewHandler $viewHandler
     */
    public function __construct(ViewHandler $viewHandler)
    {
        parent::__construct($viewHandler);
    }

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
        $code    = $e->getCode() ?: Codes::HTTP_INTERNAL_SERVER_ERROR;
        $message = $e->getMessage() ?: null;

        return $this->handle(View::create($message, $code));
    }

    /**
     * @return Response
     */
    public function notImplemented()
    {
        return $this->getServerErrorResponseBuilder()->exception(new HttpException(Codes::HTTP_NOT_IMPLEMENTED));
    }
}