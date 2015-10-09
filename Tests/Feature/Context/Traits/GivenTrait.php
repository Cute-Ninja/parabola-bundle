<?php

namespace HOT\Bundle\CommonBundle\Tests\Feature\Context\Traits;

/**
 * Class GivenTrait
 *
 * @package HOT\Bundle\CommonBundle\Tests\Feature\Context\Traits
 */
trait GivenTrait
{
    /**
     * @Given /^I am an Anonymous User$/
     */
    public function iAmAnAnonymousUser()
    {
        $this->client = $this->getContainer()->get('test.client');
    }
}