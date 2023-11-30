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
        $messages = MessageFile::toArray($this->file);
        $newMessages = [];
        foreach ($messages as $message) {
            if ($message['new']) {
                $newMessages[] = $message;
            }
        }
        return $newMessages;
    }

    public function setMessagesLikeRead(array $messages) : void
    {
        $messages = array_map(function ($message) {
            $message['new'] = false;
            return $message;
        }, MessageFile::toArray($this->file));
        MessageFile::setContent($this->file, json_encode($messages));
    }
}