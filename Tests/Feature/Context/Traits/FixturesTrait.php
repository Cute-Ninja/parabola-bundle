<?php

namespace CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits;

use Symfony\Component\Process\Process;

/**
 * Class FixturesTrait
 *
 * @package CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits
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
        $process = new Process("php bin/console doctrine:schema:create --env=test");
        $process->run();

        $process = new Process("php bin/console cute_ninja:fixture:load --env=test");
        $process->run();
    }

    /**
     * @AfterScenario
     */
    public function afterScenario()
    {
        $process = new Process("php bin/console doctrine:schema:drop --force --env=test");
        $process->run();
    }
}