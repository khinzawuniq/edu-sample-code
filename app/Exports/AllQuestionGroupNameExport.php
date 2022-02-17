<?php

namespace App\Exports;

use App\Models\QuestionGroupName;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllQuestionGroupNameExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return QuestionGroupName::all();
    }
}
