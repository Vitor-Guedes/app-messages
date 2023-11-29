<?php

use App\Messages\Http\Request;
use App\Messages\Http\Response;

if (!function_exists('view')) {
    /**
     * Include a view from filename
     *
     * @param string $filename
     * 
     * @return string
     */
    function view(string $filename) : string {
        $content = "";
        $file = BASE_VIEW . $filename;
        if (!file_exists($file)) {
            throw new Exception("File: $file, not exists.");
        }
        ob_start();
        require($file);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}

if (!function_exists('request')) {
    /**
     * Return new instance from Request
     *
     * @return Request
     */
    function request() : Request {
        static $request;

        if (!$request) {
            $request = new Request();
        }

        return $request;
    }
}

if (!function_exists('response')) {
    /**
     * Return new instance form Response
     *
     * @return Response
     */
    function response() : Response {
        static $response;

        if (!$response) {
            $response = new Response();
        }

        return $response;
    }
}