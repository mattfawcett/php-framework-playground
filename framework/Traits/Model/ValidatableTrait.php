<?php
namespace Framework\Traits\Model;

/**
 * Use this trait in one of your models to enable validation on it. Once in use,
 * you should implement your own isValid() function which should update the
 * $errors array and return true or false.
 */
trait ValidatableTrait
{
    /**
     * The errors are populated when calling isValid and contains a simple array
     * of error messages.
     */
    protected $errors = [];


    /**
     * If isValid() return false, then the errors returned by this function can
     * be used to explan what the issues are.
     */
    public function getErrors() : array
    {
        return $this->errors;
    }

    /**
     * Default isValid() function. Overwrite this in your model to actually
     * perform validation specific for that model.
     */
    public function isValid() : bool
    {
        return true;
    }
}
