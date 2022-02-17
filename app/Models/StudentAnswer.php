<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class StudentAnswer extends Model
{
    use SoftDeletes;

    protected $table = "student_answers";

    protected $fillable = [
        "course_id",
        "module_id",
        "exam_id",
        "question_id",
        "exam_by",
        "choice_answer_id",
        "choice_answer",
        "mark",
        "student_exam_id",
    ];

    public function course()
    {
      return $this->belongsTo(Course::class,'course_id','id');
    }
    public function module()
    {
      return $this->belongsTo(CourseModule::class,'module_id','id');
    }
    public function exam()
    {
      return $this->belongsTo(Exam::class,'exam_id','id');
    }
    public function question()
    {
      return $this->belongsTo(Question::class,'question_id','id');
    }
    public function questionAnswer()
    {
      return $this->belongsTo(QuestionAnswer::class,'choice_answer_id','id');
    }
    public function examBy()
    {
      return $this->belongsTo(User::class,'exam_by','id');
    }
    public function studentExam()
    {
      return $this->belongsTo(StudentExam::class,'student_exam_id','id');
    }
}
