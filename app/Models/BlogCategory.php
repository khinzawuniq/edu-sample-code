<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = "blog_categories";

    protected $fillable = [
        'category_name',
        'created_by',
        'updated_by',
        'is_active',
    ];


    public function blogs()
    {
       return $this->hasMany(KnowledgeBlog::class,'blog_category_id');
    }
}
