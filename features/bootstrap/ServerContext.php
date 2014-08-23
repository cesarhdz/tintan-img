<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Event\SuiteEvent;

 use Guzzle\Http\Client
 	, Guzzle\Http\Exception\CurlException;

use Symfony\Component\Process\Process;





/**
 * Features context
 */
class ServerContext extends BehatContext {
    /**
     * Pid for the web server
     *
     * @var int
     */
    private static $proccess;

    /**
     * Start up the web server
     *
     * @BeforeSuite
     */
    public static function setUp(SuiteEvent $event) {

    	echo "| Starting server ...\n";

        // Fetch config
        $params = $event->getContextParameters();
        $url = parse_url($params['url']);
        $port = !empty($url['port']) ? $url['port'] : 80;

        if (self::canConnectToHttpd($url['host'], $port)) {
            throw new RuntimeException('Something is already running on ' . $params['url'] . '. Aborting tests.');
        }

        // Try to start the web server
        self::startServer(
            $url['host'],
            $port,
            $params['documentRoot']
        );

        $start = microtime(true);
        $connected = false;

        // Try to connect until the time spent exceeds the timeout specified in the configuration
        while (microtime(true) - $start <= (int) $params['timeout']) {
            if (self::canConnectToHttpd($url['host'], $port)) {
                $connected = true;

                echo "| Server started at {$url['host']}:{$port}\n\n";

                break;
            }
        }
    }

    /**
     * Kill the httpd process if it has been started when the tests have finished
     *
     * @AfterSuite
     */
    public static function tearDown(SuiteEvent $event) {
    	echo "| Server stopped.\n\n";
    	self::$proccess->stop();
    }

    /**
     * See if we can connect to the httpd
     *
     * @param string $host The hostname to connect to
     * @param int $port The port to use
     * @return boolean
     */
    private static function canConnectToHttpd($host, $port) {
       // Disable error handler for now
        set_error_handler(function() { return true; });

        // Try to open a connection
        $sp = fsockopen($host, $port);

        // Restore the handler
        restore_error_handler();

        if ($sp === false) {
            return false;
        }

        fclose($sp);

        return true;
    }

    /**
     * Start the built in httpd
     *
     * @param string $host The hostname to use
     * @param int $port The port to use
     * @param string $documentRoot The document root
     * @return int Returns the PID of the httpd
     */
    private static function startServer($host, $port, $documentRoot) {
        // Build the command
        $command = sprintf('php -S %s:%d -t %s',
                            $host,
                            $port,
                            $documentRoot);

        self::$proccess = new Process($command);
        self::$proccess->start();
    }
}