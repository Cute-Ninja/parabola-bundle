<?php

namespace CuteNinja\ParabolaBundle\Tests\Feature\Context;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits\FixturesTrait;
use CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits\UtilsTrait;
use CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits\GivenTrait;
use CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits\ThenTrait;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
    protected static function createKernel(array $options = [])
    {
        return new \AppKernel('test', false);
    }

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
     * @param string   $apiName
     * @param string[] $params
     */
    public function iWantToBatchDelete($apiName, $params = [])
    {
        $this->requestApi('DELETE', '/api/' . $apiName, $params);
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

    /**
     * @param string $route
     * @param array  $parameters
     * @param bool   $referenceType
     *
     * @return string
     */
    protected function generateUrl($route, array $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->getContainer()->get('router')->generate($route, $parameters, $referenceType);
    }

    /**
     * @param TableNode|null $table
     *
     * @return array
     */
    protected function getFormData(TableNode $table = null)
    {
        $formData = [];

        if ($table) {
            $rows     = $table->getRows();
            $formData = $this->combineKeysAndValues($rows);
        }

        return $formData;
    }

    /**
     * @param string[] $tableRows
     *
     * @return array
     */
    private function combineKeysAndValues($tableRows)
    {
        $result = [];

        foreach ($tableRows as $index => $row) {
            $key   = array_shift($row);
            $value = (1 == count($row)) ? $row[0] : $row;

            // if key is an array
            if (preg_match('/([a-zA-Z]*)\[[a-zA-Z0-9]*\]/', $key, $keyMatches)) {
                $newKey = $keyMatches[1];

                // for multiple dimensions array
                if (preg_match_all('/\[([a-zA-Z0-9]*)\]/', $key, $valueMatches)) {
                    $keyValues = array_reverse($valueMatches[1]);

                    foreach ($keyValues as $index => $keyValue) {
                        $value = [$keyValue ?: $index => $value];
                    }

                    if (isset($result[$newKey]) && is_array($result[$newKey])) {
                        $value = array_merge($result[$newKey], $value);
                    }
                }

                $key = $newKey;
            }

            $result[$key] = $value;
        }

        return $result;
    }
}