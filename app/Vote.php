<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'poll', 'user', 'vote',
    ];

    // public function vote() {
    //   return $this->hasOne('App\PollOption', 'vote');
    // }

}
