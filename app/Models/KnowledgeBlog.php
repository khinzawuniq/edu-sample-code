<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeBlog extends Model
{
    protected $table = "knowledge_blogs";

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'video_upload_type',
        'video',
        'youtube_url',
        'url',
        'created_by',
        'is_active',
        'blog_category_id',
        'blog_attachment'
    ];

    public function attachments()
    {
      return $this->hasMany(BlogAttachment::class,'knowledge_blog_id','id');
    }
}
