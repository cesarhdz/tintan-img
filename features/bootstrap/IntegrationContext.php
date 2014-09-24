<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;


use CesarHdz\TinTan\Application;
use Symfony\Component\HttpFoundation\Request;

use org\bovigo\vfs\vfsStream;

/**
 * Defines application features from the specific context.
 */
class IntegrationContext implements Context, SnippetAcceptingContext
{

    private $app;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {}

    /**
     * @Given I have the dir :arg1 with these files
     */
    public function iHaveTheDirWithTheseFiles($arg1, TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @When I request for tin-tan\/pachuco.png
     */
    public function iRequestForTinTanPachucoPng()
    {
        throw new PendingException();
    }

    /**
     * @When I request for tin-tan\/pachuco.jpg
     */
    public function iRequestForTinTanPachucoJpg()
    {
        throw new PendingException();
    }

    /**
     * @When I request for tin-tan\/pachuco.gif
     */
    public function iRequestForTinTanPachucoGif()
    {
        throw new PendingException();
    }

    /**
     * @When I request for tin-tan\/pachuco.txt
     */
    public function iRequestForTinTanPachucoTxt()
    {
        throw new PendingException();
    }

    /**
     * @When I request for pachuco.jpg
     */
    public function iRequestForPachucoJpg2()
    {
        throw new PendingException();
    }

    /**
     * @Then I should get :arg1 status
     */
    public function iShouldGetStatus($arg1)
    {
        throw new PendingException();
    }


  
}
