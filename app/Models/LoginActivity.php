<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    protected $table = "login_activities";

    protected $fillable = [
        "user_id",
        "login",
        "logout",
        "ipaddress",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
