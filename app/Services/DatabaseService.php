<?php

namespace App\Services;

use Exception;
use App\Models\Message;
use App\Contracts\Service;
use App\NewMessagesStream;
use Illuminate\Http\Response;

class DatabaseService implements Service
{
    /**
     * Send menssage to conversation.
     *
     * @param array $data ['user_id' => {user_id}, 'message' => {message}]
     * @return array ['data' => {content_to_response}, 'status' => {http_code}]
     */
    public function sendMessage(array $data): array
    {
        try {
            
            return [
                'data' => Message::create($data),
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
                'data' => Message::all([
                    'user_id',
                    'message',
                    'new'
                ]),
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
        return Message::where('new', true)
            ->get()
            ->toArray();
    }

    /**
     * Update messages delivered
     *
     * @param array $messages
     * @return void
     */
    public function setMessagesLikeRead(array $messages) : void
    {
        $messageIds = array_map(function ($message) {
            return (int) $message['id'];
        }, $messages);
        Message::whereIn('id', $messageIds)
            ->update(['new' => 0]);
    }
}