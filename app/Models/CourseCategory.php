<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseCategory extends Model
{

     use SoftDeletes;
     protected $table = "course_categories";

     protected $fillable = [
         "name",
         "slug",
         "parent_id",
         "description",
         "is_active",
         "created_by",
         "image",
         "order_no"
     ];


     public function courses()
     {
        return $this->hasMany(Course::class,'course_category_id','id');
     }

     public function parent()
     {
        return $this->belongsTo(CourseCategory::class,'parent_id');
     }
     public function createdBy()
     {
       return $this->belongsTo(User::class,'created_by','id');
     }
}
