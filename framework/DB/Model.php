<?php
namespace Framework\DB;

abstract class Model
{
    public $attributes = [];

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

    public static function build(array $attributes)
    {
        $model = new static;
        $model->attributes = $attributes;
        return $model;
    }
}
