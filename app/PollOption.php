<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{

    use Notifiable;
    protected $guard = 'admin';
    
    protected $fillable = [
        'poll', 'option', 'results'
    ];

    public function votes() {
      return $this->hasMany('App\Vote', 'vote');
    }
}
