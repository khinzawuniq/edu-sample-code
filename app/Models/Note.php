<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Note extends Model
{
    use SoftDeletes;
    
    protected $table = "notes";

    protected $fillable = [
        'created_by',
        'course_id',
        'note_title',
        'note_description',
    ];

    public function course()
    {
      return $this->belongsTo(Course::class,'course_id','id');
    }
    
    public function createdBy()
    {
      return $this->belongsTo(User::class,'created_by','id');
    }
}
