<?php

namespace App\Messages\Controllers;

use App\Messages\FileManager;
use App\Messages\Http\Response;
use App\Messages\Http\ResponseStreamed;

class MessageController
{
    /**
     * File with messages 
     * 
     * @var string
     */
    protected $fileMessages = '/messages.json';

    /**
     * Index
     *
     * @return Response
     */
    public function index() : Response
    {
        return response()->view('index.php');
    }

    /**
     * Send Message
     *
     * @return Response
     */
    public function sendMessage() : Response
    {
        $data = request()->getBodyJson();

        $messages = json_decode(
            FileManager::getContent($this->fileMessages), 
            true
        );

        $messages[] = [
            'user_id' => $data['user_id'],
            'message' => $data['message'],
            'new' => true
        ];

        FileManager::setContent(
            $this->fileMessages, 
            json_encode($messages, JSON_PRETTY_PRINT)
        );
        return response()->content('', 201);
    }

    /**
     * List all messages
     *
     * @return Response
     */
    public function getAllMessages() : Response
    {
        return response()->json(
            FileManager::getContent($this->fileMessages),
            200
        );
    }

    /**
     * Delivery Server Sent Events on stream
     *
     * @return ResponseStreamed
     */
    public function serverSentEvent() : ResponseStreamed
    {
        return new ResponseStreamed(function () {
            $messages = FileManager::toArray($this->fileMessages);

            $newMessages = [];
    
            foreach ($messages as $index => $message) {
                if ($message['new']) {
                    $newMessages[] = $message;
                    $messages[$index]['new'] = false;
                }
            }
    
            FileManager::setContent(
                $this->fileMessages, 
                json_encode($messages, JSON_PRETTY_PRINT)
            );
    
            $event = "event: new_message\n"; 
            $event .= "data: " . json_encode($newMessages) . "\n";
            $event .= "\n";
            return $event;
        }, 5);
    }
}