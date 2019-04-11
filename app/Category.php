<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use Notifiable;
    protected $guard = 'admin';

    protected $fillable = [
        'title', 'parent', 'url'
    ];
}
