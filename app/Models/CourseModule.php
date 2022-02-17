<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CourseModule extends Model
{
    use SoftDeletes;
    protected $table = "course_modules";

    protected $fillable = [
        'course_id',
        'name',
        'order_no',
        'is_active',
        'description',
        "created_by"
    ];


    public function lessons()
    {
       return $this->hasMany(Lesson::class,'course_module_id','id')->orderBy('order_no');
    }
    public function exams()
    {
       return $this->hasMany(Exam::class,'module_id','id');
    }

    public function course()
    {
      return $this->belongsTo(Course::class,'course_id','id');
    }
    public function createdBy()
    {
      return $this->belongsTo(User::class,'created_by','id');
    }

}
