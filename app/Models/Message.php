<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = false;

    public $fillable = [
        'user_id',
        'message',
        'new'
    ];
}