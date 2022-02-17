<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Question extends Model
{
    protected $table = "questions";

    protected $fillable = [
        "course_id",
        "module_id",
        "exam_id",
        "question_type",
        "question",
        "correct_answer",
        "answer_no_style",
        "mark",
        "created_by",
        "question_group_name",
        'question_group_id',
        'group_status',
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
    public function createdBy()
    {
      return $this->belongsTo(User::class,'created_by','id');
    }
    public function groupName()
    {
      return $this->belongsTo(QuestionGroupName::class,'question_group_id','id');
    }
    public function statusGroupName()
    {
      return $this->belongsTo(QuestionGroupName::class,'group_status','id');
    }
    public function questionAnswer()
    {
        return $this->hasMany(QuestionAnswer::class,'question_id','id');
    }
    public function studentAnswer()
    {
        return $this->hasMany(StudentAnswer::class,'question_id','id');
    }

    public function choiceAnswer($exam_id, $qid)
    {
      $exam = Exam::where('id', $exam_id)->first();
      $choices = QuestionAnswer::where('question_id', $qid);
      
      if($exam->shuffle_answer == 1) {
        $choices = $choices->inRandomOrder()->get();
      }else {
        $choices = $choices->get();
      }

      return $choices;
    }

    public function numberStyle($number)
    {
        $data = "";

        if($number == 1) {
            $data = [
                1 => 'a.',
                2 => 'b.',
                3 => 'c.',
                4 => 'd.',
            ];
        }elseif($number == 2) {
            $data = [
                1 => 'A.',
                2 => 'B.',
                3 => 'C.',
                4 => 'D.',
            ];
        }elseif($number == 3) {
            $data = [
                1 => '1.',
                2 => '2.',
                3 => '3.',
                4 => '4.',
            ];
        }elseif($number == 4) {
            $data = [
                1 => 'i.',
                2 => 'ii.',
                3 => 'iii.',
                4 => 'iv.',
            ];
        }

        return $data;
    }
}
