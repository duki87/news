<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'comment', 'user',
    ];

    public function user() {
      return $this->belongsTo('App\User', 'user');
    }

    public function comment() {
      return $this->belongsTo('App\Comment', 'comment');
    }
}
