<?php
namespace Framework\Http;

class BaseController
{
    protected function jsonResponse($object)
    {
        header('Content-Type: application/json');
        echo json_encode($object);
    }
}
