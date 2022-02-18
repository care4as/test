<?php

namespace App\Exports;

use App\RetentionDetail;
use Maatwebsite\Excel\Concerns\FromCollection;

class RetentionDetailsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RetentionDetail::all();
    }
}
