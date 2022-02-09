<?php

namespace App\Exports;

use App\SAS;
use Maatwebsite\Excel\Concerns\FromCollection;

class SasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SAS::all();
    }
}
