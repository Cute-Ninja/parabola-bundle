<?php

namespace CuteNinja\CommonBundle\HttpResponse;

use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;

/**
 * Class AbstractResponseBuilder
 *
 * @package CuteNinja\CommonBundle\HttpResponse
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
        $this->viewHandler = $viewHandler;
    }

    /**
     * @param null $data
     *
     * @return Response
     */
    public function ok($data = null)
    {
        $code = $data ? Codes::HTTP_OK : Codes::HTTP_NO_CONTENT;

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