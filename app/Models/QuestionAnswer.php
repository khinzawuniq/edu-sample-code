<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    protected $table = "question_answers";

    protected $fillable = [
        "question_id",
        "answer",
        "answer_no",
    ];

    public function question()
    {
      return $this->belongsTo(Question::class,'question_id','id');
    }
}
