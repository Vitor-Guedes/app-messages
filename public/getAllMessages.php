<?php

header('Content-Type: application/json; charset=utf-8');

$file = "./messages.json";
echo file_get_contents($file);