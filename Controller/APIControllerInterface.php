<?php

namespace CuteNinja\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface BaseControllerInterface
 *
 * @package CuteNinja\CommonBundle\Controller
 */
interface APIControllerInterface
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request);

    /**
     * @param integer $id
     *
     * @return Response
     */
    public function getAction($id);

    /**
     * @return Response
     */
    public function postAction();

    /**
     * @param integer $id
     *
     * @return Response
     */
    public function putAction($id);

    /**
     * @param integer $id
     *
     * @return Response
     */
    public function deleteAction($id);
}