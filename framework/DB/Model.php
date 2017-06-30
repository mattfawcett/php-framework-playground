<?php
namespace Framework\DB;

use Framework\Interfaces\DB\ModelInterface;

abstract class Model implements ModelInterface
{
    /**
     * The attributes representing the state of this model
     */
    protected $attributes = [];

    /**
     * Which attributes are fillable via mass assignment
     */
    public $fillable = [];

    /**
     * Get the id this model has in the database. Will return null if the model
     * is not persisted.
     *
     * @return null|int
     */
    public function getId()
    {
        return $this->attributes['id'] ?? null;
    }

    /**
     * Get the attributes of this model
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Update the attributes of this model. Only attributes whitelisted in the
     * $fillable array will be updated.
     */
    public function fill(array $unsafeAttributes)
    {
        $safeAttributes = array_filter($unsafeAttributes, function($key) {
            return in_array($key, $this->fillable);
        }, ARRAY_FILTER_USE_KEY);

        $this->forceFill($safeAttributes);
    }

    public function forceFill(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    public static function build(array $attributes)
    {
        $model = new static;
        $model->attributes = $attributes;
        return $model;
    }

    public function __call($method, $arguments)
    {
        if (strncasecmp($method, "get", 3) == 0) {
            $camelCaseAttribute = substr($method, 3);

            $attribute = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $camelCaseAttribute));
            if(isset($this->attributes[$attribute])) {
                return $this->attributes[$attribute];
            }
        }
        trigger_error('Call to undefined method '.__CLASS__.'::' . $method . '()', E_USER_ERROR);
    }
}
