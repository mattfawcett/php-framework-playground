<?php
namespace App;

class UserTest extends TestCase
{
    public function test_settingPassword()
    {
        $user = new User;
        $user->fill(['password' => 'Password1']);

        $hash = $user->getEncryptedPassword();

        $passwordCorrect = password_verify('Password1', $hash);
        $this->assertTrue($passwordCorrect);
    }
}
