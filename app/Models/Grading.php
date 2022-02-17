<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grading extends Model
{
    protected $table = "gradings";

    protected $fillable = [
        'grading_from',
        'grading_to',
        'grading_description',
        'is_active',
        'ref_no',
        'awarding_body',
        'number_grading',
        'passing_mark',
    ];
}