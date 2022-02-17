<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionPerPage extends Model
{
    protected $table = "question_per_pages";

    protected $fillable = [
        'question_per_page',
        'description',
        'is_active',
    ];
}