<?php

// ob_implicit_flush(1);

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