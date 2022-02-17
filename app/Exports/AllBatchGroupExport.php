<?php

namespace App\Exports;

use App\Models\BatchGroup;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllBatchGroupExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BatchGroup::all();
    }
}
