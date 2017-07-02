<?php namespace App;

use DI\ContainerBuilder;
use App\Http\RequestHandler;

/**
 * Testing of RequestHandler which is the routing that glues the application.
 * Because the output of this class is the sending of headers and echoing out of
 * content, these tests are fairly slow and are only used to test the the router
 * can invoke Controller actions and handle exceptions.
 *
 * Additions to these tests should be kept at a minimum and controllers tested
 * independently in isolation.
 */
class RequestHandlerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $containerBuilder = new ContainerBuilder;
        $containerBuilder->addDefinitions(__DIR__ . '/../../app/config.php');
        $this->container = $containerBuilder->build();

        $this->handler = new RequestHandler($this->container);
    }

    /**
    * @runInSeparateProcess
    */
    public function test_validRequestToKnownUrl()
    {
        ob_start();
        $this->handler->handle('GET', '/users/1');
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(200, http_response_code());
        $this->assertRegexp('/John/', $output);
    }

    /**
    * @runInSeparateProcess
    */
    public function test_requestKnownUrlModelNotFound()
    {
        ob_start();
        $this->handler->handle('GET', '/users/0');
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(404, http_response_code());
        $this->assertEquals('{"error":"Resource not found"}', $output);
    }

    /**
    * @runInSeparateProcess
    */
    public function test_requestUnknownUrl()
    {
        ob_start();
        $this->handler->handle('GET', '/unknown');
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(404, http_response_code());
        $this->assertEquals('{"error":"Resource not found"}', $output);
    }
}
