<?php

namespace CuteNinja\ParabolaBundle\HttpResponse;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractResponseBuilder
 *
 * @package CuteNinja\ParabolaBundle\HttpResponse
 */
abstract class AbstractResponseBuilder
{
    /**
     * @var ViewHandler
     */
    private $viewHandler;

    /**
     * @param ViewHandler $viewHandler
     */
    public function __construct(ViewHandler $viewHandler)
    {
        $this->viewHandler    = $viewHandler;
    }

    /**
     * @param null $data
     *
     * @return Response
     */
    public function ok($data = null)
    {
        $code = $data ? Response::HTTP_OK : Response::HTTP_NO_CONTENT;

        return $this->handle(View::create(null, $code));
    }

    /**
     * @param View $view
     *
     * @return Response
     */
    protected function handle(View $view)
    {
        return $this->viewHandler->handle($view);
    }

    /**
     * @return SuccessResponseBuilder
     */
    protected function getSuccessResponseBuilder()
    {
        return new SuccessResponseBuilder($this->viewHandler);
    }

    /**
     * @return ClientErrorResponseBuilder
     */
    protected function getClientErrorResponseBuilder()
    {
        return new ClientErrorResponseBuilder($this->viewHandler);
    }

    /**
     * @return ServerErrorResponseBuilder
     */
    protected function getServerErrorResponseBuilder()
    {
        return new ServerErrorResponseBuilder($this->viewHandler);
    }
}