<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trip';

    public $timestamps = false;

    protected $fillable = [
        'country',
        'user_id',
        'from_city',
        'number_of_people',
        'number_of_days',
        'budget',
        'preferred_food',
        'transportation',
        'flight_id'
    ];
}
