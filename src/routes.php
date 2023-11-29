<?php

use App\Messages\FileManager;

$app->get('/', function () {
    return view('index.php');
});

$app->post('/sendMessages', function () {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $file = "/messages.json";
    $messages = json_decode(FileManager::getContent($file), true);

    $messages[] = [
        'user_id' => $data['user_id'],
        'message' => $data['message'],
        'new' => true
    ];

    FileManager::setContent($file, json_encode($messages, JSON_PRETTY_PRINT));
    http_response_code(201);
});

$app->get('/getAllMessages', function () {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    return FileManager::getContent("/messages.json");
});

$app->get('/serverSentEvents', function () {
    header('Access-Control-Allow-Origin: *');
    header("Content-Type: text/event-stream");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Connection: keep-alive");

    ob_start();

    if (connection_aborted()) {
        exit();
    }

    $file = "./messages.json";

    while (true) {
        $messages = file_get_contents($file);
        $messages = json_decode($messages, true) ?? [];

        $newMessages = [];

        foreach ($messages as $index => $message) {
            if ($message['new']) {
                $newMessages[] = $message;
                $messages[$index]['new'] = false;
            }
        }

        file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT));

        echo "event: new_message\n";
        echo "data: " . json_encode($newMessages) . "\n";
        echo "\n";

        ob_flush();
        flush();

        sleep(5);
    }

    ob_end_flush();
});