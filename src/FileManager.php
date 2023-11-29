<?php

namespace App\Messages;

use Exception;
use function file_exists;
use function json_decode;
use function file_get_contents;
use function file_put_contents;

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

    /**
     * Convert content to array
     *
     * @param string $filename
     * @return array
     */
    public static function toArray(string $filename) : array
    {
        $content = static::getContent($filename);
        return json_decode($content, true);
    }
}