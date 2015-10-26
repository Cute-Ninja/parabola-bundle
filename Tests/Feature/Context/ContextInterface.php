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
     */
    public function iWantToCreate($apiName);

    /**
     * @param $apiName
     * @param $id
     */
    public function iWantToEdit($apiName, $id);

    /**
     * @param $apiName
     * @param $id
     */
    public function iWantToDelete($apiName, $id);
}