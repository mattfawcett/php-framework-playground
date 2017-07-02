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
    protected $attributes = [
        'first_name' => null,
        'last_name' => null,
        'email' => null,
        'hashed_password' => null,
    ];
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

        $this->assertEquals(1, $user->getAttribute('id'));
        $this->assertEquals('John', $user->getAttribute('first_name'));
        $this->assertEquals('Smith', $user->getAttribute('last_name'));
        $this->assertEquals('user1@example.com', $user->getAttribute('email'));
    }

    public function test_find_forNonExistingRecord()
    {
        $user = $this->repo->find(0);

        $this->assertNull($user);
    }

    public function test_findOrFail_forExistingRecord()
    {
        $user = $this->repo->findOrFail(1);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @expectedException Framework\Exceptions\ModelNotFoundException
     */
    public function test_findOrFail_forNonExistingRecord()
    {
        $this->repo->findOrFail(0);
    }


    public function test_all()
    {
        $users = $this->repo->all();
        $this->assertEquals(3, count($users));

        $this->assertInstanceOf(User::class, $users[0]);
        $this->assertEquals(1, $users[0]->getId());
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
        $user->forceFill(['email' => 'updated@example.com']);

        $updatedModel = $this->repo->update($user);
        $this->assertEquals($updatedModel, $user);

        $user = $this->repo->find(1);
        $this->assertEquals('updated@example.com', $user->getAttribute('email'));
    }

    public function test_create()
    {
        $user = User::build([
            'first_name' => 'Samual',
            'last_name' => 'Peters',
            'email' => 'sam.peters@example.com'
        ]);

        $savedModel = $this->repo->create($user);

        $user = $this->repo->find($savedModel->getId());
        $this->assertEquals($savedModel->getId(), $user->getId());
        $this->assertEquals('sam.peters@example.com', $user->getAttribute('email'));
    }
}
