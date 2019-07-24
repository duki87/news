<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'news_id','user', 'reply', 'email', 'body', 'status', 'url', 'name'
    ];

    public function likes() {
      return $this->hasMany('App\Like', 'comment');
    }

    public function user() {
      return $this->belongsTo('App\User', 'user');
    }
}
