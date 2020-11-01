<?php
namespace App\Imports;

use
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelImport implements FromCollection
{
   use Importable;

   public function collection(array $row)
   {
     return $row;
     return response()->json($row);
   }
}

 ?>
