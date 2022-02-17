<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTime;
use App\Models\StudentAssignment;
class Lesson extends Model
{
    use SoftDeletes;
    protected $table = "lessons";
    protected $appends = ['is_downloading','is_downloaded','percent'];
    protected $fillable = [
        'course_id',
        'course_module_id',
        'name',
        'description',
        'order_no',
        'file_path',
        'assingment_allow_submission_from_date',
        'assingment_due_date',
        'assingment_cut_off_date',
        'assingment_remind_date',
        'is_display_description',
        'lesson_type',
        'url',
        'open_quiz_date',
        'close_quiz_date',
        'time_limit',
        'time_type',
        'is_active',
        "created_by",
        "zoom_id",
        "zoom_password",
        "display",
        "activity_restriction",
        "grade_restriction",
        "payment_restriction",
        "certificate_exam_id",
    ];


    public function createdBy()
    {
      return $this->belongsTo(User::class,'created_by','id');
    }
    public function module()
    {
      return $this->belongsTo(CourseModule::class,'course_module_id','id');
    }
    public function course()
    {
      return $this->belongsTo(Course::class,'course_id','id');
    }
    public function exam()
    {
       return $this->hasMany(Exam::class,'lesson_id','id');
    }

    public function checkSubmitted($student_id){
      $submit = StudentAssignment::where('student_id',$student_id)->where('lesson_id',$this->id)->first();
      return $submit;
    }


    public function getIsDownloadingAttribute()
    {
       return false;
    }
    public function getIsDownloadedAttribute()
    {
       return false;
    }
    public function getPercentAttribute()
    {
       return 0;
    }

    public function getRemainingTimeAttribute()
    {
      $datetime1 = new DateTime();
      $datetime2 = new DateTime($this->assingment_due_date);
      $remain = "";

      if ($datetime1 >= $datetime2) {
        return 0;
      }
      $interval = $datetime2->diff($datetime1);
      $y = $interval->format('%y');
      $m = $interval->format('%m');
      $d = $interval->format('%a');
      $h = $interval->format('%h');
      $min = $interval->format('%i');
      $s = $interval->format('%s');
      if ($y > 0) {
        $remain .= $y ." Year".($y == 1 ? ' ' :'s ');
      }
      if ($m > 0) {
        $remain .= $m ." Month".($m == 1 ? ' ' :'s ');
      }
      if ($d > 0) {
        $remain .= $d ." Day".($d == 1 ? ' ' :'s ');
      }
      if ($h > 0) {
        $remain .= $h ." Hour".($h == 1 ? ' ' :'s ');
      }
      if ($min > 0) {
        $remain .= $min ." Minute".($min == 1 ? ' ' :'s ');
      }
      if ($s > 0) {
        $remain .= $s ." Second".($s == 1 ? ' ' :'s ');
      }
      return $remain;
    }
}
