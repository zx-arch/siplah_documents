<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Model
{
    use SoftDeletes;
    protected $table = 'user_login';
    protected $fillable = [
        'id',
        'username',
        'password'
    ];
    protected $hidden = [];
}