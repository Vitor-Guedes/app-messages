<?php

namespace App\Messages\Entity;

use App\Messages\FileManager;

class NewMessagesStream extends Event
{
    protected $name = 'new_message';

    protected $data = '';

    /**
     * Resolve de streame event to response
     *
     * @return string
     */
    public function resolve() : string
    {
        $file = '/messages.json';
        $messages = FileManager::toArray($file);

        $newMessages = [];

        foreach ($messages as $index => $message) {
            if ($message['new']) {
                $newMessages[] = $message;
                $messages[$index]['new'] = false;
            }
        }

        FileManager::setContent(
            $file, 
            json_encode($messages, JSON_PRETTY_PRINT)
        );

        $this->data = json_encode($newMessages);
        return (string) $this;
    }
}