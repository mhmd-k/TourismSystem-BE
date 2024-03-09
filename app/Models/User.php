<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    protected $table = "user";

    public $timestamps = false;

    protected $fillable = [
        'name',
        'image_reference',
        'email',
        'password',
    ];
}
