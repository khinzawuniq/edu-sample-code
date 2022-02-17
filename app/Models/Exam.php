<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Exam extends Model
{
    use SoftDeletes;
    
    protected $table = "exams";

    protected $fillable = [
        'course_id',
        'module_id',
        'exam_name',
        'description',
        'exam_duration',
        'duration_type',
        'time_limit',
        'time_type',
        'start_date',
        'end_date',
        'attempts_allow',
        'shuffle_question',
        'shuffle_answer',
        'passing_mark',
        'grading_id',
        'grade_mark_from',
        'grade_mark_to',
        'grade_description',
        'question_per_page',
        'created_by',
        'is_active',
        'lesson_id',
    ];

    public function course()
    {
      return $this->belongsTo(Course::class,'course_id','id');
    }
    public function module()
    {
      return $this->belongsTo(CourseModule::class,'module_id','id');
    }
    public function lesson()
    {
      return $this->belongsTo(Lesson::class,'lesson_id','id');
    }
    public function createdBy()
    {
      return $this->belongsTo(User::class,'created_by','id');
    }
    public function grading()
    {
      return $this->belongsTo(Grading::class,'grading_id','id');
    }
    public function question()
    {
      return $this->hasMany(Question::class,'exam_id','id');
    }
    public function questionAssign()
    {
      return $this->hasMany(AssignQuestion::class,'exam_id','id');
    }
    public function numberQuestion()
    {
      return $this->belongsTo(QuestionPerPage::class,'question_per_page','id');
    }

    public function studentExam()
    {
      return $this->hasMany(StudentExam::class,'exam_id','id');
    }
}
