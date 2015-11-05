<?php

namespace CuteNinja\ParabolaBundle\HttpResponse;

use FOS\RestBundle\Context\Context;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Knp\Component\Pager\Pagination\PaginationInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

/**
 * Class SuccessResponseBuilder
 *
 * @package CuteNinja\ParabolaBundle\HttpResponse
 */
class SuccessResponseBuilder extends AbstractResponseBuilder
{
    /**
     * @param ViewHandler $viewHandler
     */
    public function __construct(ViewHandler $viewHandler)
    {
        parent::__construct($viewHandler);
    }

    /**
     * @param mixed $object
     * @param array $serializationGroups
     *
     * @return Response
     */
    public function buildSingleObjectResponse($object, array $serializationGroups = [])
    {
        if (null === $object) {
            return $this->getClientErrorResponseBuilder()->notFound();
        } elseif (is_array($object) && empty($object)) {
            return $this->getClientErrorResponseBuilder()->notFound();
        }

        $view = View::create($object, Response::HTTP_OK);

        $context = new Context();
        $context->setSerializeNull(true);

        if (!empty($serializationGroups)) {
            $context->addGroups($serializationGroups);
        }

        $view->setSerializationContext($context);

        return $this->handle($view);
    }

    /**
     * @param PaginationInterface $pagination
     * @param Request             $request
     * @param Router              $router
     * @param array               $serializationGroups
     *
     * @return mixed
     */
    public function buildMultiObjectResponse(
        PaginationInterface $pagination,
        Request $request,
        Router $router,
        array $serializationGroups = array()
    ) {
        if (empty($pagination->getItems())) {
            return $this->handle(View::create(null, Response::HTTP_NO_CONTENT));
        }

        $paginationData = $pagination->getPaginationData();
        $link           = $this->buildPaginationLink($paginationData, $request, $router);

        $headers = [];
        if (!empty($link)) {
            $headers['Link'] = $link;
        }

        if (isset($paginationData['totalCount'])) {
            $headers['X-Total-Count'] = $paginationData['totalCount'];
        }

        $view    = View::create($pagination->getItems(), Response::HTTP_OK, $headers);
        $context = new Context();
        $context->setSerializeNull(true);

        if (!empty($serializationGroups)) {
            $context->addGroups($serializationGroups);
        }

        $view->setSerializationContext($context);

        return $this->handle($view);
    }

    /**
     * @param string $resourceRouteName
     * @param array  $parameters
     *
     * @return Response
     */
    public function postSuccess($resourceRouteName = '', array $parameters = [])
    {
        return $this->handle(View::createRouteRedirect($resourceRouteName, $parameters, Response::HTTP_CREATED));
    }

    /**
     * @return Response
     */
    public function putSuccess()
    {
        return $this->handle(View::create(null, Response::HTTP_NO_CONTENT));
    }

    /**
     * @return Response
     */
    public function deleteSuccess()
    {
        return $this->handle(View::create(null, Response::HTTP_NO_CONTENT));
    }

    /**
     * @param array   $paginationData
     * @param Request $request
     * @param Router  $router
     *
     * @return string
     */
    private function buildPaginationLink(array $paginationData, Request $request, Router $router)
    {
        $routeBaseParameters = $request->query->all();

        $currentPage = array_key_exists('current', $paginationData) ? $paginationData['current'] : 1;
        $links       = [];
        foreach (['prev' => 'previous', 'next', 'first', 'last'] as $index => $page) {
            if (!isset($paginationData[$page])) {
                continue;
            }

            if (!array_key_exists($paginationData[$page], $links) && $paginationData[$page] != $currentPage) {
                $routeBaseParameters['page']   = $paginationData[$page];
                $links[$paginationData[$page]] = sprintf(
                    '<%s>; rel="%s"',
                    $router->generate($request->get('_route'), $routeBaseParameters, true),
                    is_int($index) ? $page : $index
                );
            }
        }

        return implode(',', $links);
    }
}