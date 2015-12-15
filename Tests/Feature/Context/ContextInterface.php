<?php

namespace CuteNinja\ParabolaBundle\Tests\Feature\Context;

/**
 * Interface ContextInterface
 *
 * @package CuteNinja\ParabolaBundle\Tests\Feature\Context
 */
interface ContextInterface
{
    /**
     * @param $apiName
     */
    public function iWantToList($apiName);

    /**
     * @param $apiName
     * @param $id
     */
    public function iWantToSeeTheDetails($apiName, $id);

    /**
     * @param $apiName
     * @param $params
     */
    public function iWantToCreate($apiName, $params);

    /**
     * @param $apiName
     * @param $id
     * @param $params
     */
    public function iWantToEdit($apiName, $id, $params);

    /**
     * @param $apiName
     * @param $id
     */
    public function iWantToDelete($apiName, $id);
}