<?php

namespace App\Exports;

use App\OptIn;
use Maatwebsite\Excel\Concerns\FromCollection;

class OptinExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OptIn::all();
    }
}
