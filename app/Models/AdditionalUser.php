<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalUser extends Model
{
    protected $table = "additional_users";

    protected $fillable = [
        "user_id",
        "additional_label",
        "additional_value",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
