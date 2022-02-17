<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignQuestion extends Model
{
    protected $table = "assign_questions";

    protected $fillable = [
        "course_id",
        "module_id",
        "exam_id",
        "group_id",
        "question_id",
        "status",
    ];

    public function qgroup()
    {
      return $this->belongsTo(QuestionGroupName::class,'group_id','id');
    }
}