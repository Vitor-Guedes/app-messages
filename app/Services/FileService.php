<?php

namespace App\Services;

use Exception;
use App\MessageFile;
use App\Contracts\Service;
use App\NewMessagesStream;
use Illuminate\Http\Response;

class FileService implements Service
{
    protected $file = 'messages.json';

    /**
     * Send menssage to conversation.
     *
     * @param array $data ['user_id' => {user_id}, 'message' => {message}]
     * @return array ['data' => {content_to_response}, 'status' => {http_code}]
     */
    public function sendMessage(array $data): array
    {
        try {
            $messages = MessageFile::toArray($this->file);
            $data['new'] = true;
            $messages[] = $data;
            return [
                'data' => MessageFile::setContent($this->file, json_encode($messages)),
                'status' => Response::HTTP_CREATED
            ];
        } catch (Exception $e) {
            return [
                'data' => $e->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    /**
     * Retrive all messages
     *
     * @return array ['data' => {content_to_response}, 'status' => {http_code}]
     */
    public function getAllMessages(): array
    {
        try {
            return [
                'data' => MessageFile::toArray($this->file),
                'status' => Response::HTTP_OK
            ];
        } catch (Exception $e) {
            return [
                'data' => $e->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    /**
     * Return event function to stream
     *
     * @return array ['event' => {event_function}, 'status' => {http_code}, 'headers' =>  {array}]
     */
    public function getEventStream(): array
    {
        try {
            return [
                'event' => NewMessagesStream::resolve(),
                'status' => Response::HTTP_OK,
                'headers' => [
                    'Cache-Control' => 'no-cache',
                    'Content-Type' => 'text/event-stream'
                ]
            ];
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Retrive new message
     *
     * @return array
     */
    public function getNewMessages(): array
    {
        $messages = MessageFile::toArray($this->file);
        $newMessages = [];
        foreach ($messages as $message) {
            if ($message['new']) {
                $newMessages[] = $message;
            }
        }
        return $newMessages;
    }

    /**
     * Update messages delivered
     *
     * @param array $messages
     * @return void
     */
    public function setMessagesLikeRead(array $messages) : void
    {
        $messages = array_map(function ($message) {
            $message['new'] = false;
            return $message;
        }, MessageFile::toArray($this->file));
        MessageFile::setContent($this->file, json_encode($messages));
    }
}