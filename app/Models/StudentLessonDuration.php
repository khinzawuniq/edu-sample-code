<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentLessonDuration extends Model
{
    protected $table = "student_lesson_durations";

    protected $fillable = [
        "user_id",
        "course_id",
        "module_id",
        "lesson_id",
        "playtime_seconds",
        "play",
        "pause",
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
    
}