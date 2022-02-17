<?php

namespace App\Exports;

use App\Models\Grading;
use Maatwebsite\Excel\Concerns\FromCollection;

class GradingExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Grading::all();
    }
}
