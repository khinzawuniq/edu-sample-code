<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogAd extends Model
{
    protected $table = "blog_ads";

    protected $fillable = [
        "ads_image",
        "ads_url",
        "is_active",
    ];
}
