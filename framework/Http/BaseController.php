<?php
namespace Framework\Http;

class BaseController
{
    protected function jsonResponse($object, $statusCode = 200) : Response
    {
        $response = new Response(json_encode($object));
        $response->addHeader('Content-Type', 'application/json');
        $response->setStatusCode($statusCode);
        return $response;
    }
}
