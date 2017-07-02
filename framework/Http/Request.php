<?php
namespace Framework\Http;

/**
 * An object representing an HTTP Request.
 *
 * Currently just used to get post attributes
 */
class Request
{
    /**
     *  Get the posted data array
     */
    public function all() : array
    {
        return $_POST;
    }
}
