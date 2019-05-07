<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    public function images() {
      return $this->hasMany('App\NewsImage', 'news_id');
    }

    protected $fillable = [
        'category', 'title', 'body', 'keywords', 'author', 'cover'
    ];
}
