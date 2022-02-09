<?php

namespace App\Exports;

use App\Availbench;
use Maatwebsite\Excel\Concerns\FromCollection;

class AvailbenchExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Availbench::all();
    }
}
