<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchGroupModule extends Model
{
    protected $table = "batch_group_modules";

    protected $fillable = [
        "course_id",
        "batch_group_id",
        "module_id",
    ];

    public function batch_group()
    {
      return $this->belongsTo(BatchGroup::class,'batch_group_id','id');
    }
    
    public function course()
    {
      return $this->belongsTo(Course::class,'course_id','id');
    }
}