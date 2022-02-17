<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionGroupName extends Model
{
    use SoftDeletes;

    protected $table = "question_group_names";

    protected $fillable = [
        'group_name',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class,'question_group_id','id');
    }
}
