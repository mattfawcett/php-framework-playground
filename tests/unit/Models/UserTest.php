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
}
