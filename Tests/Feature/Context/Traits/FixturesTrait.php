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
     * @BeforeSuite
     */
    public static function beforeSuite()
    {
        $process = new Process("php bin/console doctrine:schema:create --env=test");
        $process->setTimeout(3600);
        $process->run();

        $process = new Process("php bin/console cute_ninja:fixture:load --env=test");
        $process->setTimeout(3600);
        $process->run();
    }

    /**
     * @AfterScenario @regenerateDB
     */
    public function regenerateDBAfterScenario()
    {
        $process = new Process("php bin/console doctrine:schema:drop --force --env=test");
        $process->setTimeout(3600);
        $process->run();

        $process = new Process("php bin/console doctrine:schema:create --env=test");
        $process->setTimeout(3600);
        $process->run();

        $process = new Process("php bin/console cute_ninja:fixture:load --env=test");
        $process->setTimeout(3600);
        $process->run();
    }
}