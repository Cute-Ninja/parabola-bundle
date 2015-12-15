<?php

namespace CuteNinja\ParabolaBundle\Tests\Feature\Context;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits\FixturesTrait;
use CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits\UtilsTrait;
use CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits\GivenTrait;
use CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits\ThenTrait;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class BaseContext
 *
 * @package CuteNinja\ParabolaBundle\Tests\Feature\Context
 */
abstract class BaseContext extends WebTestCase implements ContextInterface, SnippetAcceptingContext, KernelAwareContext
{
    use UtilsTrait;
    use FixturesTrait;
    use GivenTrait;
    use ThenTrait;

    /**
     * @var KernelInterface
     */
    protected $kernelSymfony;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Response
     */
    protected $response;

    /**
     * {@inheritdoc}
     */
    public function iWantToList($apiName)
    {
        $this->requestApi('GET', '/api/' . $apiName);
    }

    /**
     * {@inheritdoc}
     */
    public function iWantToSeeTheDetails($apiName, $id)
    {
        $this->requestApi('GET', '/api/' . $apiName . '/' . $id);
    }

    /**
     * {@inheritdoc}
     */
    public function iWantToCreate($apiName, $params = [])
    {
        $this->requestApi('POST', '/api/' . $apiName, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function iWantToEdit($apiName, $id, $params = [])
    {
        $this->requestApi('PUT', '/api/' . $apiName . '/' . $id, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function iWantToDelete($apiName, $id)
    {
        $this->requestApi('DELETE', '/api/' . $apiName . '/' . $id);
    }

    /**
     * @param $method
     * @param $uri
     */
    public function requestApi($method, $uri, $params = [])
    {
        $this->client->request($method, $uri, $params);
        $this->response = $this->client->getResponse();
    }
}