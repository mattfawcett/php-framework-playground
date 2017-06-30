<?php
namespace Framework\DB;

use Framework\Interfaces\DB\ModelInterface;

abstract class Model implements ModelInterface
{
    public $attributes = [];

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
     * Update the attributes of this model. Only attributes whitelisted in the
     * $fillable array will be updated.
     */
    public function fill(array $unsafeAttributes)
    {
        $safeAttributes = array_filter($unsafeAttributes, function($key) {
            return in_array($key, $this->fillable);
        }, ARRAY_FILTER_USE_KEY);

        $this->attributes = array_merge($this->attributes, $safeAttributes);
    }

    public static function build(array $attributes)
    {
        $model = new static;
        $model->attributes = $attributes;
        return $model;
    }
}
