<?php

namespace HOT\Bundle\CommonBundle\Tests\Feature\SerializationSchema;

/**
 * Interface SerializationSchemaInterface
 *
 * @package HOT\Bundle\CommonBundle\Tests\Feature\SerializationSchema
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