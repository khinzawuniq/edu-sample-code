<?php

namespace App\Exports;

use App\Models\QuestionAnswer;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllQuestionAnswerExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return QuestionAnswer::all();
    }
}
