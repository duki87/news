<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    public function images() {
      return $this->hasMany('App\NewsImage', 'news_id');
    }

    public function comments() {
      return $this->hasMany('App\Comment', 'news_id');
    }

    protected $fillable = [
        'category', 'title', 'body', 'keywords', 'author', 'cover'
    ];
}
