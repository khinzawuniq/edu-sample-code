<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    protected $table = "chat_groups";

    protected $fillable = [
        "name",
        "course_id",
        "ref_no",
        "avatar",
        "active_status",
    ];
}
