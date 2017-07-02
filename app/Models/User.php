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
        'hashed_password' => null,
    ];

    public $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * The errors are populated when calling isValid and contains a simple array
     * of error messages.
     */
    protected $errors = [];

    public function fill(array $attributes)
    {
        parent::fill($attributes);
        if($attributes['password']) {
            $this->attributes['hashed_password'] = password_hash($attributes['password'], PASSWORD_BCRYPT);
        }
    }

    public function isValid() : bool
    {
        $this->errors = [];

        if(!$this->attributes['first_name']) {
            $this->errors[] = 'First name is required';
        }

        if(!$this->attributes['last_name']) {
            $this->errors[] = 'Last name is required';
        }

        if($this->attributes['email']) {
            if(strpos($this->attributes['email'], '@') === false) {
                $this->errors[] = 'Email is invalid';
            }
        } else {
            $this->errors[] = 'Email is required';
        }

        if(!$this->attributes['hashed_password']) {
            $this->errors[] = 'Password is required';
        }

        return empty($this->errors);
    }

    public function getErrors() : array
    {
        return $this->errors;
    }
}
