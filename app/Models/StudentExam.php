<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class StudentExam extends Model
{
    use SoftDeletes;

    protected $table = "student_exams";

    protected $fillable = [
        "course_id",
        "module_id",
        "exam_id",
        "exam_by",
        "start_exam",
        "stop_exam",
        "time_taken",
        "state",
        "grade",
        "total_mark",
        "exam_status",
        "grade_id",
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
    public function examBy()
    {
      return $this->belongsTo(User::class,'exam_by','id');
    }

    public function studentAnswer()
    {
      return $this->hasMany(StudentAnswer::class,'student_exam_id','id');
    }

    public function beforeAnswer($student_exam_id, $exam_id)
    {
      $answer = StudentAnswer::where('student_exam_id', $student_exam_id)->where('exam_id', $exam_id)->groupBy('question_id')->get();

      return $answer;
    }
}
