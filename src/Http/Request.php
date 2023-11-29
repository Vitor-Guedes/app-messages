<?php

namespace App\Messages\Http;

class Request
{
    /**
     * Request Method
     *
     * @return string
     */
    public function getMethod() : string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Request Uri
     *
     * @return string
     */
    public function getUri() : string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Return array with request body parameters
     *
     * @return array
     */
    public function getBodyJson() : array
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}