<?php

$data = file_get_contents('php://input');
$data = json_decode($data, true);

$file = "./messages.json";

if (!file_exists($file)) {
    echo "arquivo não existe.";
    return ;
}

$messages = file_get_contents($file);
$messages = json_decode($messages, true) ?? [];

var_dump($_POST);
var_dump($data);

$messages[] = [
    'user_id' => $data['user_id'],
    'message' => $data['message'],
    'new' => true
];

file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT));