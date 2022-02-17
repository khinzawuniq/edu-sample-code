<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchGroup extends Model
{
    protected $table = "batch_groups";

    protected $fillable = [
        "course_id",
        "group_name",
        "accessed_module_no",
        "created_by",
        "is_active",
    ];

    public function createdBy()
    {
      return $this->belongsTo(User::class,'created_by','id');
    }
    
    public function course()
    {
      return $this->belongsTo(Course::class,'course_id','id');
    }

    public function module()
    {
        return $this->hasMany(BatchGroupModule::class,'batch_group_id','id');
    }
}
