<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroupUser extends Model
{
    //
    protected $fillable = [
        'user_id',
        'user_group_id',
    ];
}
