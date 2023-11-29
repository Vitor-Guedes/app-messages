<?php

namespace App\Messages\Http;

class Response
{
    protected $headers = [];

    protected $body = '';

    /**
     * Add Header to Response 
     *
     * @param string $key
     * @param string $value
     * @return Response
     */
    public function setHeader(string $key, string $value) : Response
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * Define status code
     *
     * @param integer $code
     * @return Response
     */
    public function setStatusCode(int $code) : Response
    {
        http_response_code($code);
        return $this;
    }

    /**
     * Change Responsto to delivery json content
     *
     * @param string $content
     * @param integer $code
     * @return Response
     */
    public function json(string $content, int $code) : Response
    {
        $this->setHeader('Content-Type', 'application/json');
        $this->setStatusCode($code);
        $this->body = $content;
        return $this;
    }

    /**
     * Define content Response
     *
     * @param string $content
     * @param integer $code
     * @return Response
     */
    public function content(string $content = '', int $code = 200) : Response
    {
        $this->setStatusCode($code);
        $this->body = $content;
        return $this;
    }

    /**
     * Delivery Response
     *
     * @return void
     */
    public function send() : void
    {
        $this->headers();
        echo $this->body;
    }

    /**
     *
     * @return void
     */
    public function headers() : void
    {
        foreach ($this->headers as $key => $header) {
            if (is_string($key)) {
                header("$key: $header", true);
            } else {
                header($header);
            }
        }
    }

    /**
     * Return view content
     *
     * @param string $filename
     * @return Response
     */
    public function view(string $filename) : Response
    {
        $this->setHeader('Content-type', 'text/html; charset=UTF-8');
        $this->body = view($filename);;
        return $this;
    }
}