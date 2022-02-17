<?php

namespace App\Exports;

use App\Models\EnrolUser;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllEnrolUserExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return EnrolUser::all();
    }
}
