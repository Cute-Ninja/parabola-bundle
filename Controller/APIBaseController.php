<?php

namespace CuteNinja\Bundle\CommonBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use CuteNinja\Bundle\CommonBundle\HttpResponse\ClientErrorResponseBuilder;
use CuteNinja\Bundle\CommonBundle\HttpResponse\ServerErrorResponseBuilder;
use CuteNinja\Bundle\CommonBundle\HttpResponse\SuccessResponseBuilder;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

/**
 * Class APIBaseController
 *
 * @package CuteNinja\Bundle\CommonBundle\Controller
 */
abstract class APIBaseController extends FOSRestController implements APIControllerInterface
{
    const PAGINATION_PAGE_DEFAULT = 1;
    const PAGINATION_LIMIT_DEFAULT = 25;

    /**
     * @return SuccessResponseBuilder
     */
    protected function getSuccessResponseBuilder()
    {
        return $this->container->get('hot.response_builder.success');
    }

    /**
     * @return ClientErrorResponseBuilder
     */
    protected function getClientErrorResponseBuilder()
    {
        return $this->container->get('hot.response_builder.client_error');
    }

    /**
     * @return ServerErrorResponseBuilder
     */
    protected function getServerErrorResponseBuilder()
    {
        return $this->container->get('hot.response_builder.server_error');
    }

    /**
     * @return Paginator
     */
    protected function getPaginator()
    {
        return $this->get('knp_paginator');
    }

    /**
     * @return Router
     */
    protected function getRouter()
    {
        return $this->get('router');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    protected function getPageForPagination(Request $request)
    {
        return $request->get('page', self::PAGINATION_PAGE_DEFAULT);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    protected function getLimitForPagination(Request $request)
    {
        return $request->get('limit', self::PAGINATION_LIMIT_DEFAULT);
    }
}