<?php
namespace App;

use Mockery;
use App\UserRepository;
use App\Http\Controllers\UsersController;
use Framework\Http\Request;
use Framework\Http\Response;

class UsersControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->repo = new UserRepository($this->conn);
        $this->controller = new UsersController($this->repo);

        $this->john = [
            'id' => 1,
            'email' => 'user1@example.com',
            'first_name' => 'John',
            'last_name' => 'Smith',
        ];
        $this->tim = [
            'id' => 2,
            'email' => 'tim@example.com',
            'first_name' => 'Tim',
            'last_name' => 'Smart',
        ];
        $this->alan = [
            'id' => 3,
            'email' => 'alan@example.com',
            'first_name' => 'Alan',
            'last_name' => 'Parker',
        ];
    }

    public function test_index()
    {
        $response = $this->controller->index();
        $this->assertEquals(200, $response->statusCode);
        $this->assertJsonResponse([$this->john, $this->tim, $this->alan], $response);
    }

    public function test_show()
    {
        $response = $this->controller->show(1);
        $this->assertEquals(200, $response->statusCode);
        $this->assertJsonResponse($this->john, $response);
    }

    public function test_store_valid()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('all')->andReturn([
            'first_name' => 'Matt',
            'last_name' => 'Fawcett',
            'email' => 'matt@example.com',
            'password' => 'Password1',
        ]);

        $response = $this->controller->store($request);
        $this->assertEquals(201, $response->statusCode);
        $this->assertJsonResponse([
            'id' => '4',
            'first_name' => 'Matt',
            'last_name' => 'Fawcett',
            'email' => 'matt@example.com',
        ], $response);
    }

    protected function assertJsonResponse($expectedData, Response $response)
    {
        $this->assertEquals('application/json', $response->headers['Content-Type']);
        $this->assertEquals($expectedData, json_decode($response->body, true));
    }
}
