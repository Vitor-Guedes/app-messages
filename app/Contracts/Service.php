<?php

namespace App\Contracts;

interface Service
{
    /**
     * Send menssage to conversation.
     *
     * @param array $data ['user_id' => {user_id}, 'message' => {message}]
     * @return array ['data' => {content_to_response}, 'status' => {http_code}]
     */
    public function sendMessage(array $data) : array;

    /**
     * Retrive all messages
     *
     * @return array ['data' => {content_to_response}, 'status' => {http_code}]
     */
    public function getAllMessages() : array;

    /**
     * Return event function to stream
     *
     * @return array ['event' => {event_function}, 'status' => {http_code}, 'headers' =>  {array}]
     */
    public function getEventStream() : array;

    /**
     * Retrive new message
     *
     * @return array
     */
    public function getNewMessages() : array;

    /**
     * Update messages delivered
     *
     * @param array $messages
     * @return void
     */
    public function setMessagesLikeRead(array $messages) : void;
}