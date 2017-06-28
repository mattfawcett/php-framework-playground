<?php
namespace Framework\DB;

abstract class Model
{
    public $attributes;

    public static function build(array $attributes)
    {
        $model = new static;
        $model->attributes = $attributes;
        return $model;
    }
}
