<?php

namespace App;

use Framework\DB\Model;

class User extends Model
{
    /**
     * Default attributes for a new User
     */
    protected $attributes = [
        'first_name' => null,
        'last_name' => null,
        'email' => null,
        'encrypted_password' => null,
    ];

    public function fill(array $attributes)
    {
        parent::fill($attributes);
        if(isset($attributes['password'])) {
            $this->attributes['encrypted_password'] = password_hash($attributes['password'], PASSWORD_BCRYPT);
        }
    }
}
