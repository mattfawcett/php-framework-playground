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
        $paramsString = file_get_contents('php://input');
        $data = [];
        parse_str($paramsString, $data);
        return $data;
    }
}
