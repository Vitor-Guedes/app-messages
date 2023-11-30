<?php

namespace App;

use Illuminate\Support\Facades\Storage;

class MessageFile
{
    public static function getContent(string $file)
    {
        if (!static::fileExists($file)) {
            return "";
        }
        return Storage::get($file);
    } 

    public static function setContent(string $file, string $content)
    {
        Storage::put($file, $content);
    }

    public static function toArray(string $file)
    {
        if (static::fileExists($file)) {
            return json_decode(static::getContent($file), true) ?? [];
        }
        return [];
    } 

    public static function fileExists(string $file)
    {
        return Storage::has($file);
    }
}