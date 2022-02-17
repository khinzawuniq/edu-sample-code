<?php

namespace App\Exports;

use App\Models\AssignQuestion;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllAssignQuestionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AssignQuestion::all();
    }
}
