<?php

namespace App\Exports;

use App\Models\CourseModule;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllCourseModuleExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CourseModule::all();
    }
}
