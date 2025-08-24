<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $status
 * @property string $message
 * @property string $comment
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
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
