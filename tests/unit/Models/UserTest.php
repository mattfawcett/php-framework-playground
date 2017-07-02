<?php
namespace App;

class UserTest extends TestCase
{
    public function test_settingPasswordHash()
    {
        $user = new User;
        $user->fill(['password' => 'Password1']);

        $hash = $user->getHashedPassword();

        $passwordCorrect = password_verify('Password1', $hash);
        $this->assertTrue($passwordCorrect);
    }

    public function test_validationWithValidAttributes()
    {
        $user = new User;
        $user->fill($this->validAttributes());

        $this->assertTrue($user->isValid());
        $this->assertEquals([], $user->getErrors());
    }

    public function test_validationWithMissingRequiredAttributes()
    {
        $user = new User;

        $this->assertFalse($user->isValid());
        $this->assertEquals([
            'First name is required',
            'Last name is required',
            'Email is required',
            'Password is required',
        ], $user->getErrors());
    }

    public function test_validationWitInvalidEmail()
    {
        $user = new User;
        $user->fill($this->validAttributes(['email' => 'invalid']));

        $this->assertFalse($user->isValid());
        $this->assertEquals(['Email is invalid'], $user->getErrors());
    }

    public function test_toArray_shouldExposeAllAttributesExceptHashedPassword()
    {
        $user = new User;
        $user->fill($this->validAttributes());

        // make this user appear like a saved model
        $user->forceFill(['id' => 10]);

        $array = $user->toArray();
        $this->assertEquals([
            'first_name',
            'last_name',
            'email',
            'id',
        ], array_keys($array));
    }

    protected function validAttributes($overrides = [])
    {
        return array_merge([
            'first_name' => 'Matt',
            'last_name' => 'Fawcett',
            'email' => 'matt@example.com',
            'password' => 'Password1',
        ], $overrides);
    }
}
