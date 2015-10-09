<?php

namespace CuteNinja\Bundle\CommonBundle\Tests\Feature\Context\Traits;

use Symfony\Component\Process\Process;

/**
 * Class FixturesTrait
 *
 * @package CuteNinja\Bundle\CommonBundle\Tests\Feature\Context\Traits
 */
trait FixturesTrait
{
    /**
     * @var array
     */
    private $fixtures;

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        $process = new Process("php app/console doctrine:schema:create --env=test");
        $process->run();

        $process = new Process("php app/console cute_ninja:fixture:load --env=test");
        $process->run();
    }

    /**
     * @AfterScenario
     */
    public function afterScenario()
    {
        $process = new Process("php app/console doctrine:schema:drop --force --env=test");
        $process->run();
    }

}