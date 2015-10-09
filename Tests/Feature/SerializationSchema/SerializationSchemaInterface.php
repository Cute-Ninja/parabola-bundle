<?php

namespace CuteNinja\CommonBundle\Tests\Feature\SerializationSchema;

/**
 * Interface SerializationSchemaInterface
 *
 * @package CuteNinja\CommonBundle\Tests\Feature\SerializationSchema
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