<?php

namespace App\Exports;

use App\Models\QuestionPerPage;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllQuestionPerPageExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return QuestionPerPage::all();
    }
}
