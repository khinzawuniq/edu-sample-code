<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
class Course extends Model
{

    use SoftDeletes;
    protected $table = "courses";

    protected $fillable = [
        "course_category_id",
        "course_name",
        "slug",
        "course_code",
        "description",
        "image",
        "start_date",
        "end_date",
        "is_active",
        "created_by",
        'enrol_no',
        'enable_enrol_no',
        'fees',
        'fees_type',
        'order_no',
        'time_limit',
        'time_type',
    ];


    public function category()
    {
      return $this->belongsTo(CourseCategory::class,'course_category_id','id');
    }

    public function createdBy()
    {
      return $this->belongsTo(User::class,'created_by','id');
    }

    public function enrolUser()
    {
      return $this->hasMany(EnrolUser::class,'course_id','id');
    }
    
    public function batchGrup()
    {
      return $this->hasMany(BatchGroup::class,'course_id','id');
    }

    public function exams()
    {
      return $this->hasMany(Exam::class,'course_id','id');
    }
    
    public function lessons()
    {
      return $this->hasMany(Lesson::class,'course_id','id');
    }

    public function studentLessonDuration()
    {
      return $this->hasMany(StudentLessonDuration::class, 'course_id', 'id');
    }

    public function lessonDuration()
    {
      return $this->hasMany(LessonDuration::class, 'course_id', 'id');
    }

}
