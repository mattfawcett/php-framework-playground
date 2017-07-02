<?php
namespace Framework\Exceptions;

use Exception;

/**
 * An exception that is fired when calling findOrFail on a
 * Framework\Http\Repository and no record is found.
 */
class ModelNotFoundException extends Exception
{
}
