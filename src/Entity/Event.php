<?php

namespace App\Messages\Entity;

/**
 * Event to streamed
 */
class Event
{
    /**
     * Event name
     *
     * @var string
     */
    protected $name = '';

    /**
     * Event data
     *
     * @var string
     */
    protected $data = '';

    /**
     * Resolve de streame event to response
     *
     * @return string
     */
    public function resolve() : string
    {
        return (string) $this;
    }

    /**
     * 
     * @return string
     */
    public function __toString() : string
    {
        $eventFormat = "event:" . $this->name . PHP_EOL;
        $eventFormat .= "data:" . $this->data . PHP_EOL;
        return $eventFormat .= PHP_EOL;
    }
}