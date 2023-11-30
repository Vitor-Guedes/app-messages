<?php

namespace App;

use App\Contracts\Service;

class NewMessagesStream
{
    public static function resolve()
    {
        return function () {
            ob_start();

            $service = static::service();

            while (true) {
                if (connection_aborted()) {
                    break;
                }

                $messages = $service->getNewMessages();

                $event = "event: " . static::eventName() . PHP_EOL;
                $event .= "data: " . json_encode($messages) . PHP_EOL;
                $event .= PHP_EOL;

                echo $event;

                if ($messages) {
                    $service->setMessagesLikeRead($messages);
                }

                ob_flush();
                flush();

                sleep(5);
            }
        };
    }

    public static function service() : Service
    {
        return app()->make(Service::class);
    }

    public static function eventName()
    {
        return "new_message";
    }
}