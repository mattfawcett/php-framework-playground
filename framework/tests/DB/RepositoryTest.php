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
    public function test_find_forExistingRecord()
    {
        $repo = $this->container->get(UserRepository::class);
        $user = $repo->find(1);

        $this->assertInstanceOf(User::class, $user);

        $this->assertEquals(1, $user->attributes['id']);
        $this->assertEquals('John', $user->attributes['first_name']);
        $this->assertEquals('Smith', $user->attributes['last_name']);
        $this->assertEquals('user1@example.com', $user->attributes['email']);
    }
}
