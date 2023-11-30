<?php

namespace App\Contracts;

interface Service
{
    public function sendMessage(array $data) : array;

    public function getAllMessages() : array;

    public function getEventStream() : array;

    public function getNewMessages() : array;

    public function setMessagesLikeRead(array $messages) : void;
}