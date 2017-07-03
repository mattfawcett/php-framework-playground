<?php
namespace Framework\DB;

use Framework\Interfaces\DB\ModelInterface;

/**
 * A BaseClass that can be inherited from to represent a data entity.
 * Models typically map to a database table.
 */
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

    /**
     * Get a single attribute of this model.
     *
     * Dynamic getter functions can also be used. so the 2 following calls are equal
     *
     *   $model->getAttribute('first_name')
     *   $model->getFirstName()
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Update attributes of this model. Only attributes whitelisted in the
     * $fillable array will be updated.
     *
     * Any attributes not specified in the array passed in will not be touched
     *
     * @return void
     */
    public function fill(array $unsafeAttributes)
    {
        $safeAttributes = array_filter($unsafeAttributes, function ($key) {
            return in_array($key, $this->fillable);
        }, ARRAY_FILTER_USE_KEY);

        $this->forceFill($safeAttributes);
    }

    /**
     * Update attributes of this model. This should only be called when it can
     * be guarenteed that the $attributes are safe.
     *
     * @return void
     */
    public function forceFill(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    /**
     * Build a model instance using the attributes. This function is used by the
     * Repository to build models.
     */
    public static function build(array $attributes) : ModelInterface
    {
        $model = new static;
        $model->attributes = $attributes;
        return $model;
    }

    /**
     * Adds dynamic attribute getter functions
     *
     * $model->getAttribute('first_name') equals $model->getFirstName()
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (strncasecmp($method, "get", 3) == 0) {
            $camelCaseAttribute = substr($method, 3);

            $attribute = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $camelCaseAttribute));
            if (array_key_exists($attribute, $this->attributes)) {
                return $this->attributes[$attribute];
            }
        }
        trigger_error('Call to undefined method '.__CLASS__.'::' . $method . '()', E_USER_ERROR);
    }
}
