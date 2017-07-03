<?php
namespace App;

use JsonSerializable;
use Framework\DB\Model;
use Framework\Traits\Model\ValidatableTrait;

class User extends Model implements JsonSerializable
{
    use ValidatableTrait;

    /**
     * Default attributes for a new User
     */
    protected $attributes = [
        'first_name' => null,
        'last_name' => null,
        'email' => null,
        'hashed_password' => null,
    ];

    /**
     * Which attributes are safe to fill via mass assignment
     */
    public $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * Populate the models attributes. Special handing for the password
     * attribute, which is converted to a hashed_password for persistance.
     *
     * @param array $attribute An array of attributes which should be filled
     * @return void
     */
    public function fill(array $attributes)
    {
        parent::fill($attributes);
        if(isset($attributes['password'])) {
            $this->attributes['hashed_password'] = password_hash($attributes['password'], PASSWORD_BCRYPT);
        }
    }

    /**
     * Is the current representation of this User model valid
     *
     * @return bool
     */
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
     * Get an array representation of the model that can be used for serializing
     * to json. Should leave out any internal data.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $array = $this->getAttributes();
        unset($array['hashed_password']);
        return $array;
    }
}
