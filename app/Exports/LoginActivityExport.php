<?php

namespace App\Exports;

use App\Models\LoginActivity;
use Maatwebsite\Excel\Concerns\FromCollection;

class LoginActivityExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LoginActivity::all();
    }
}
