<?php

namespace App\Exports;

use App\Models\SlideShow;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllSlideShowExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SlideShow::all();
    }
}
