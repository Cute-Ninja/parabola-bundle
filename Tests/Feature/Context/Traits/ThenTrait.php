<?php

namespace CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits;

/**
 * Class GivenTrait
 *
 * @package CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits
 */
trait ThenTrait
{
    /**
     * @Then /^the response should be JSON$/
     */
    public function theResponseShouldBeJson()
    {
        $this->assertTrue(
            $this->response->headers->contains('Content-Type', 'application/json'),
            $this->response->headers
        );
    }

    /**
     * @Then /^the response status code should be (\d+)$/
     *
     * @param integer $statusCode
     */
    public function theResponseStatusCodeShouldBe($statusCode)
    {
        $this->assertEquals(
            $statusCode,
            $this->response->getStatusCode()
        );
    }

    /**
     * @Then /^the response body should be empty$/
     */
    public function theResponseBodyShouldBeEmpty()
    {
        $this->assertEmpty($this->response->getContent());
    }

    /**
     * @Then the response should contain :value
     */
    public function responseShouldContain($value)
    {
        $this->assertContains($value, $this->response->getContent());
    }

    /**
     * @Then the value of the field :key is equal to :value
     *
     * @param string         $key
     * @param string|integer $value
     */
    public function theValueOfTheFieldIsEqualTo($key, $value)
    {
        $bodyAsJson = json_decode($this->response->getContent());
        $this->assertEquals($value, $bodyAsJson->{$key});
    }

    /**
     * @Then the list should contains :numberOfItems items
     *
     * @param $numberOfItems
     */
    public function theListShouldContainsACertainNumberOfItems($numberOfItems)
    {
        $this->assertTrue(
            $this->response->headers->contains('X-Total-Count', $numberOfItems),
            $this->response->headers
        );
    }

    /**
     * @Then the response must be optimized
     */
    public function theResponseMustBeOptimized()
    {
        $profile = $this->client->getProfile();

        $this->assertLessThanOrEqual(
            5,
            $profile->getCollector('db')->getQueryCount()
        );

        $this->assertLessThanOrEqual(
            500,
            $profile->getCollector('db')->getTime()
        );
    }

    /**
     * @param array $allowedKeys
     */
    protected function theResponseBodyShouldContainTheDetailsOf(array $allowedKeys)
    {
        $json = json_decode($this->response->getContent());

        $this->checkAnArrayOfKey($allowedKeys, $json);
    }

    /**
     * @param array           $allowedKeys
     * @param \stdClass|array $array
     */
    private function checkAnArrayOfKey(array $allowedKeys, $array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->checkAnArrayOfKey($allowedKeys, $value);
            }

            if(!is_numeric($key)) {
                $this->assertTrue(in_array($key, $allowedKeys), "The key $key shouldn't be exposed.");
            }
        }
    }
}