<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogAttachment extends Model
{
    protected $table = "blog_attachments";

    protected $fillable = [
        'knowledge_blog_id',
        'attachment',
    ];
}
