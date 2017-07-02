<?php

namespace App;

use JsonSerializable;
use Framework\DB\Model;

class User extends Model implements JsonSerializable
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

    /**
     * Populate the models attributes. Special handing for the password
     * attribute, which is converted to a hashed_password for persistance.
     */
    public function fill(array $attributes)
    {
        parent::fill($attributes);
        if(isset($attributes['password'])) {
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

    /**
     * If isValid() return false, then the errors returned by this function can
     * be used to explan what the issues are.
     */
    public function getErrors() : array
    {
        return $this->errors;
    }

    /**
     * Get an array representation of the model that can be used for serializing
     * to json. Should leave out any internal data.
     * @return array
     */
    public function jsonSerialize()
    {
        $array = $this->getAttributes();
        unset($array['hashed_password']);
        return $array;
    }
}
