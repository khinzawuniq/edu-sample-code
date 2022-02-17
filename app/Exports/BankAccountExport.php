<?php

namespace App\Exports;

use App\Models\BankAccount;
use Maatwebsite\Excel\Concerns\FromCollection;

class BankAccountExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BankAccount::all();
    }
}
