<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Assert\Assertion as assert;


require_once 'ServerContext.php';


//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends ServerContext
{

    private $response;
    private $client;

    private $requestUrl;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->client  = new GuzzleHttp\Client();
        $this->baseUrl = $parameters['url'];
    }


    /**
     * @Given /^I\'m using my own server$/
     */
    public function iMUsingMyOwnServer()
    {
        // Check app has started
    }

    /**
     * @When /^I request for the image "([^"]*)"$/
     */
    public function iRequestForTheImage($uri)
    {
        $this->requestUrl  = $this->baseUrl . '/' . trim($uri, '/');

        $this->response = $this->client
            ->get($this->requestUrl);
    }

    /**
     * @Then /^I should get an (\d+) x (\d+) image$/
     */
    public function iShouldGetAnXImage($arg1, $arg2)
    {

        $stream = $this->response->getBody();
        $stream->read(1024);
        var_dump($this->response);

        // echo stream_get_meta_data($img);
        // fclose($img);

        // assert::notNull($this->response->getContentLength());
        assert::startsWith($this->response->getContentType(), 'image/');
    }
}
