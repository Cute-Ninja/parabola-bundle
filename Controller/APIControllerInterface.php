<?php

namespace CuteNinja\ParabolaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface BaseControllerInterface
 *
 * @package CuteNinja\ParabolaBundle\Controller
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
     * @param Request $request
     * @param integer $id
     *
     * @return Response
     */
    public function getAction(Request $request, $id);

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request);

    /**
     * @param Request $request
     * @param integer $id
     *
     * @return Response
     */
    public function putAction(Request $request, $id);

    /**
     * @param Request $request
     * @param integer $id
     *
     * @return Response
     */
    public function deleteAction(Request $request, $id);
}