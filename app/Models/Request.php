<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'email',
        'status',
        'message',
        'comment'
    ];
}
