<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use DateTime;
class StudentAssignment extends Model
{
    use SoftDeletes;
    protected $table = "student_assignment";
    protected $fillable = [
        "student_id",
        "assignment_file",
        "lession_id",
        "submission_date",
        "mark",
        "remark",
        "created_at",
        "updated_at"
    ];


    public function student()
    {
      return $this->belongsTo(User::class,'student_id','id');
    }

    public function getSubmittedTime($date)
    {
      $datetime1 = new DateTime($date);
      $datetime2 = new DateTime($this->submission_date);
      $interval = $datetime2->diff($datetime1);
      $y = $interval->format('%y');
      $m = $interval->format('%m');
      $d = $interval->format('%a');
      $h = $interval->format('%h');
      $min = $interval->format('%i');
      $s = $interval->format('%s');
      $remain = "Assignment was submitted ";
      $early_late = $datetime2 > $datetime1 ? ' late.' : ' early.';
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
      return $remain.$early_late;
    }
}
