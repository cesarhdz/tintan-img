<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;


use CesarHdz\TinTan\Application;
use Symfony\Component\HttpFoundation\Request;

use Assert\Assertion as assert;

/**
 * Defines application features from the specific context.
 */
class IntegrationContext implements Context, SnippetAcceptingContext
{

    private $app;
    private $request;
    private $response;


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->app = new Application();

        $this->dir = dirname(dirname(__FILE__ ));
        $this->imgFolder = 'img';

        $this->app->dir($this->dir);
        $this->app->version('@test');
    }

    /**
     * @Given I have these files
     *
     * We make sure file exists before running tests
     */
    public function iHaveTheseFiles(TableNode $files)
    {
        foreach ($files as $file) {
            $path = $this->getImagePath($file['file']);
            assert::file($path);
        }
    }

    /**
     * @When I request :uri uri
     */
    public function iRequestAnUri($uri)
    {
        $this->app->bootstrap();

        // Errors will break tests
        $this->app->error(function (\Exception $e, $code) {
            if($code == 500) throw $e;
        });

        $this->request = Request::create($uri, 'GET');
        $this->response = $this->app->handle($this->request);
    }

    /**
     * @Then I should get :status code
     */
    public function iShouldGetCode($status)
    {
        assert::eq($this->response->getStatusCode(), intval($status));
    }

    
    /**
     * @Then I should get :type content type header
     */
    public function iShouldGetTypeContentTypeHeader($type)
    {
        assert::eq($this->response->headers->get('content-type'), $type);
    }


    private function getImagePath($file){
        return $this->dir . '/' . $this->imgFolder . '/' . $file;
    }


    /**
     * @Then I should get an image
     */
    public function iShouldGetAnImage()
    {
        // see http://php.net/manual/en/function.imagecreatefromstring.php/
        $data = $this->response->getContent();
        assert::true(imagecreatefromstring($data) != false);
    }
}
