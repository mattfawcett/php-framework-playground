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

        $this->assertEquals(1, $user->attributes['id']);
        $this->assertEquals('Mike', $user->attributes['first_name']);
        $this->assertEquals('Smith', $user->attributes['last_name']);
    }
}
