<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = "settings";

    protected $fillable = [
        'default_password',
        'email_letter',
        'email',
        'first_phone',
        'second_phone',
        'map',
        'default_image',
    ];
    
}
