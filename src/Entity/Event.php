<?php

namespace App\Messages\Entity;

class Event
{
    protected $name = '';

    protected $data = '';

    public function resolve()
    {
        return (string) $this;
    }

    public function __toString() : string
    {
        $eventFormat = "event:" . $this->name . PHP_EOL;
        $eventFormat .= "data:" . $this->data . PHP_EOL;
        return $eventFormat .= PHP_EOL;
    }
}