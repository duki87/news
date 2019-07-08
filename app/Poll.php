<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = [
        'title', 'news', 'description', 'values'
    ];

    public function votes() {
      return $this->hasMany('App\Vote', 'poll');
    }
}
