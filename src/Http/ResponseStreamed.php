<?php

namespace App\Messages\Http;

class ResponseStreamed extends Response
{
    public function __construct(protected $event, protected int $interval) 
    {
        $this->setHeader('Access-Control-Allow-Origin', '*');
        $this->setHeader('Content-Type', 'text/event-stream');
        $this->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
        $this->setHeader('Connection', 'keep-alive');
    }

    public function send() : void
    {
        $this->headers();

        ob_start();

        while (true) {

            if (connection_aborted()) {
                break ;
            }

            $event = new $this->event;
            echo $event->resolve();
           
            ob_flush();
            flush();
            
            sleep($this->interval);
        }
    }
}