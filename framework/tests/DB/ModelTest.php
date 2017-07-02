<?php
namespace Framework\DB;

use Framework\TestCase;

/**
 * Define a user model from the base model class to use for testing purposes
 */
class UserWithFillable extends Model
{
    /**
     * Which attributes are fillable via mass assignment
     */
    public $fillable = [
        'first_name'
    ];

    protected $attributes = [
        'first_name',
        'last_name',
    ];
}

class ModelTest extends TestCase
{
    public function test_fill_shouldOnlyMassAssignFillableAttributes()
    {
        $user = UserWithFillable::build([
            'id' => 1,
            'first_name' => 'John',
            'last_name' => 'Smith'
        ]);

        $user->fill([
            'id' => 2,
            'first_name' => 'Mike',
            'last_name' => 'Bell'
        ]);

        $this->assertEquals(1, $user->getId());
        $this->assertEquals('Mike', $user->getFirstName());
        $this->assertEquals('Smith', $user->getLastName());
    }

    /**
     * @expectedException PHPUnit\Framework\Error\Error
     */
    public function test_dynamicGettersInvalid()
    {
        $user = UserWithFillable::build([]);

        $user->getNonExistantAttribute();
    }
}
