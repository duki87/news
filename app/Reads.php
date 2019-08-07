<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reads extends Model
{
    protected $fillable = [
        'news', 'user', 'session', 'read', 'share'
    ];
}
