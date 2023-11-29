<?php

if (!function_exists('view')) {
    function view(string $filename) {
        $file = BASE_VIEW . $filename;
        if (file_exists($file)) {
            return include($file);
        }
        throw new Exception("File: $file, not exists.");
    }
}