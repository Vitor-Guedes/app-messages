<?php

namespace App\Messages;

use Exception;

class FileManager
{
    /**
     * Get content from file
     *
     * @param string $filename
     * @return string
     */
    public static function getContent(string $filename)
    {
        $file = BASE_FILE . $filename;
        if (file_exists($file)) {
            return file_get_contents($file);
        }
        throw new Exception("File: $filename not founded.");
    }

    /**
     * Put content into file
     *
     * @param string $filename
     * @param string $content
     * @return void
     */
    public static function setContent(string $filename, string $content) : void
    {
        $file = BASE_FILE . $filename;
        if (file_exists($file)) {
            file_put_contents($file, $content);
        }
    }
}