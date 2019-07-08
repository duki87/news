<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'user', 'reply', 'body', 'status', 'url'
    ];

    public function likes() {
      return $this->hasMany('App\Like', 'comment');
    }
}
