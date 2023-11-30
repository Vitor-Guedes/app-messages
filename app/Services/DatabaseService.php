<?php

namespace App\Services;

use App\Contracts\Service;
use App\NewMessagesStream;
use Exception;
use Illuminate\Http\Response;

class DatabaseService implements Service
{
    public function sendMessage(array $data): array
    {
        try {
            
            return [
                'data' => '',
                'status' => Response::HTTP_CREATED
            ];
        } catch (Exception $e) {
            return [
                'data' => $e->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function getAllMessages(): array
    {
        try {
            return [
                'data' => [],
                'status' => Response::HTTP_OK
            ];
        } catch (Exception $e) {
            return [
                'data' => $e->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

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

    public function getNewMessages(): array
    {
        $newMessages = [];
        return $newMessages;
    }

    public function setMessagesLikeRead(array $messages) : void
    {
        
    }
}