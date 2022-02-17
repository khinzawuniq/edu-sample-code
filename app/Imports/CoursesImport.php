<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\CourseCategory;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CoursesImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     return new Course([
    //         //
    //     ]);
    // }

    public function collection(Collection $rows)
    {
        foreach($rows as $row) {
            $category   = CourseCategory::where('name', $row['coursecategory'])->first();
            $user       = User::where('name', $row['createdby'])->first();
            
            if($user) {
                $created_by = $user->id;
            }else {
                $created_by = 1;
            }
            if(!empty($row['startdate'])) {
                $startdate = Carbon::parse($row['startdate'])->format('Y-m-d');
            }else {
                $startdate = null;
            }
            if(!empty($row['enddate'])) {
                $enddate = Carbon::parse($row['enddate'])->format('Y-m-d');
            }else {
                $enddate = null;
            }

            if(!empty($category)) {
                Course::create([
                    "course_category_id"    => $category->id,
                    "course_name"           => $row['coursename'],
                    "description"           => $row['description'],
                    "start_date"            => $startdate,
                    "end_date"              => $enddate,
                    "is_active"             => 1,
                    "created_by"            => $created_by,
                ]);
            }
        }
    }

    public function sheets(): array
    {
        return [
            0 => new CoursesImport(),
        ];
    }
}
