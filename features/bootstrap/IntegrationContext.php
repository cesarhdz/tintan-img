<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;


use CesarHdz\TinTan\Application;
use Symfony\Component\HttpFoundation\Request;

use org\bovigo\vfs\vfsStream;

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
        $this->app->dir(vfsStream::url(''));
        $this->app->version('@test');
    }

    /**
     * @Given I have the dir :dir with these files
     */
    public function iHaveTheDirWithTheseFiles($dir, TableNode $tree)
    {
        $root = vfsStream::setup($dir);

        foreach ($tree as $file) {
            vfsStream::newFile($file['file'])->at($root);
            // assert file_exists(vfsStream::url($dir) . '/' . $file['file']))
        }
    }

    /**
     * @When I request :uri uri
     */
    public function iRequestTinTanHatPngUri($uri)
    {
        $this->app->bootstrap();
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
     * @Then I should get <type> content type header
     */
    public function iShouldGetTypeContentTypeHeader()
    {
        throw new PendingException();
    }

}
