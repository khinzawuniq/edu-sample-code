<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    protected $table = "townships";

    protected $fillable = [
        'region_id',
        'name',
    ];
}
