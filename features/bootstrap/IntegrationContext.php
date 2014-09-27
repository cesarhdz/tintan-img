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

    private $dir;
    private $imgFolder;

    private $image;


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
    public function i_have_these_files(TableNode $files)
    {
        foreach ($files as $file) {
            $path = $this->getImagePath($file['file']);
            assert::file($path);
        }
    }

    /**
     * @When I request :uri uri
     */
    public function i_request_an_uri($uri)
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
    public function i_should_get_code($status)
    {
        assert::eq($this->response->getStatusCode(), intval($status));
    }

    
    /**
     * @Then I should get :type content type header
     */
    public function i_should_get_type_content_type_header($type)
    {
        assert::eq($this->response->headers->get('content-type'), $type);
    }


    private function getImagePath($file){
        return $this->dir . '/' . $this->imgFolder . '/' . $file;
    }

    /**
     * Return an image from response content
     * @return [type] [description]
     */
    private function getImageFromResponse(){
        $data = $this->response->getContent();
        return imagecreatefromstring($data);
    }


    /**
     * @Then I should get an image
     */
    public function i_should_get_an_image()
    {
        // see http://php.net/manual/en/function.imagecreatefromstring.php/
        
        assert::true($this->getImageFromResponse() != false);
    }

    /**
     * @Given I register a :presetName preset using :filterName filter, options
     *
     * @param String preset Name of the preset
     * @param String filter Name of the filter without _Filter_ suffix
     * @param TableNode options Options used to register preset
     */
    public function i_register_a_preset_using_filter_options($preset, $filter, TableNode $table)
    {
        $args = array();

        foreach ($table as $row) {
            $args[$row['key']] = $row['val'];
        }

        $this->app->preset($preset, $filter, $args);
    }

    /**
     * @Then I should get an image of :width x :height px
     */
    public function i_should_get_an_image_of_x_px($width, $height)
    {
        assert::eq(imagesx($this->getImageFromResponse()), $width);
        assert::eq(imagesy($this->getImageFromResponse()), $height);
    }

}
