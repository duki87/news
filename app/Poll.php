<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Poll extends Model
{
    use Notifiable;
    protected $guard = 'admin';

    protected $fillable = [
        'title', 'news', 'description'
    ];

    public function poll_options() {
      return $this->hasMany('App\PollOption', 'poll');
    }

    public function votes() {
      return $this->hasMany('App\Vote', 'poll');
    }
}
