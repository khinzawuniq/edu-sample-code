<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonDuration extends Model
{
    protected $table = "lesson_durations";

    protected $fillable = [
        "course_id",
        "course_module_id",
        "lesson_id",
        "lesson_duration",
    ];

    public function course()
    {
      return $this->belongsTo(Course::class,'course_id','id');
    }
    public function module()
    {
      return $this->belongsTo(CourseModule::class,'course_module_id','id');
    }
    public function lesson()
    {
      return $this->belongsTo(Lesson::class,'lesson_id','id');
    }
    
}