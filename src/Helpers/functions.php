<?php

if (!function_exists('view')) {
    function view(string $filename) {
        $file = BASE_VIEW . $filename;
        if (!file_exists($file)) {
            throw new Exception("File: $file, not exists.");
        }
        include($file);
    }
}