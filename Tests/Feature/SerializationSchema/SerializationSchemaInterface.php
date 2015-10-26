<?php

namespace CuteNinja\ParabolaBundle\Tests\Feature\SerializationSchema;

/**
 * Interface SerializationSchemaInterface
 *
 * @package CuteNinja\ParabolaBundle\Tests\Feature\SerializationSchema
 */
interface SerializationSchemaInterface
{
    /**
     * @param array $groupNames
     *
     * @return array
     */
    public function getSchemaByGroupNames(array $groupNames = array());
}