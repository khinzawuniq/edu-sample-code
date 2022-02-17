<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampusAddress extends Model
{
    protected $table = "campus_addresses";

    protected $fillable = [
        "campus_name",
        "address",
        "phone",
        "email",
        "is_active",
    ];
}
