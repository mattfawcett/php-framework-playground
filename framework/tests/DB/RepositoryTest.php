<?php
namespace Framework\DB;

use Framework\TestCase;

/**
 * Define a repository from the base repository class to use for testing purposes
 */
class UserRepository extends Repository
{
    public $table = 'users';
    public $modelClass = User::class;
}

/**
 * Define a user model from the base model class to use for testing purposes
 */
class User extends Model
{

}

class RepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->repo = new UserRepository($this->conn);
    }

    public function test_find_forExistingRecord()
    {
        $user = $this->repo->find(1);

        $this->assertInstanceOf(User::class, $user);

        $this->assertEquals(1, $user->attributes['id']);
        $this->assertEquals('John', $user->attributes['first_name']);
        $this->assertEquals('Smith', $user->attributes['last_name']);
        $this->assertEquals('user1@example.com', $user->attributes['email']);
    }

    public function test_find_forNonExistingRecord()
    {
        $user = $this->repo->find(0);

        $this->assertNull($user);
    }

    public function test_all()
    {
        $users = $this->repo->all();
        $this->assertEquals(3, count($users));

        $this->assertInstanceOf(User::class, $users[0]);
        $this->assertEquals(1, $users[0]->attributes['id']);
    }

    public function test_remove_whenRecordExists()
    {
        $this->assertTrue($this->repo->remove(1));

        $users = $this->repo->all();
        $this->assertEquals(2, count($users));
    }

    public function test_remove_whenRecordDoesNotExist()
    {
        $this->assertFalse($this->repo->remove(0));

        $users = $this->repo->all();
        $this->assertEquals(3, count($users));
    }

    public function test_update()
    {
        $user = $this->repo->find(1);
        $user->attributes['email'] = 'updated@example.com';

        $this->repo->update($user);

        $user = $this->repo->find(1);
        $this->assertEquals('updated@example.com', $user->attributes['email']);
    }

    public function test_create()
    {
        $user = User::build([
            'first_name' => 'Samual',
            'last_name' => 'Peters',
            'email' => 'sam.peters@example.com'
        ]);

        $id = $this->repo->create($user);

        $user = $this->repo->find($id);
        $this->assertEquals($id, $user->attributes['id']);
        $this->assertEquals('sam.peters@example.com', $user->attributes['email']);
    }
}
