<?php

namespace App\Exports;

use App\Models\BatchGroupModule;
use Maatwebsite\Excel\Concerns\FromCollection;

class BatchGroupModuleExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BatchGroupModule::all();
    }
}
