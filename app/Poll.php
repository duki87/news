<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
