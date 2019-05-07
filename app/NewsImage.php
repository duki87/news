<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsImage extends Model
{
    protected $fillable = [
        'news_id', 'destination', 'author', 'title', 'description'
    ];
}
