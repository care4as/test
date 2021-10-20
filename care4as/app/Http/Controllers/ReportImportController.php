<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReportImportController extends Controller
{
    public function load(){
        $dataTables = DB::table('datatables_timespan')
        ->get()
        ->toArray();

        $refinedDataTables = array();

        foreach($dataTables as $key => $entry){
            $entry = (array) $entry;
            $refinedDataTables[$entry['data_table']]['min_date'] = date_format(date_create_from_format('Y-m-d', $entry['min_date']), 'd.m.Y');
            $refinedDataTables[$entry['data_table']]['max_date'] = date_format(date_create_from_format('Y-m-d', $entry['max_date']), 'd.m.Y');
        }

        return view('reports.reportImport', compact('refinedDataTables'));
    }

}

