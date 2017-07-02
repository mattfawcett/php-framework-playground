<?php
namespace Framework\Http;

/**
 * An Base Class for controller to inherit from. Provides useful helper
 * functions for building up Framework\Http\Response objects.
 */
abstract class BaseController
{
    protected function jsonResponse($object, $statusCode = 200) : Response
    {
        $response = new Response(json_encode($object));
        $response->addHeader('Content-Type', 'application/json');
        $response->setStatusCode($statusCode);
        return $response;
    }
}
