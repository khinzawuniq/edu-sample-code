<?php

namespace App\Exports;

use App\Models\Course;
use App\Models\CourseCategory;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CoursesExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $all_courses = Course::select('course_category_id','course_name','description','start_date','end_date','is_active','created_by');

        if($this->request->course_category_id) {
            $all_courses = $all_courses->where('course_category_id', $this->request->course_category_id);
        }

        $all_courses = $all_courses->get();
        
        $courses = [];
        foreach($all_courses as $cours) {
            $cours->course_category_id = $cours->category->name;
            $cours->is_active = ($cours->is_active == 1)? "No":"Yes";
            if(!empty($cours->created_by)) {
                $cours->created_by = $cours->createdBy->name;
            }else {
                $cours->created_by = 'Super Admin';
            }
            
            $courses[] = $cours;
        }

        return collect($courses);
    }

    public function headings(): array
    {
        return [
            'CourseCategory',
            'CourseName',
            'Description',
            'StartDate',
            'EndDate',
            'SuspendedCourse',
            'CreatedBy',
        ];
    }
}
