<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormImportCustomerExport implements WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array {
        return [
        	'code',
            'name',
            'email',    
        	'address',
            'phone',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,            
            'C' => 30,            
            'D' => 20,            
            'E' => 50,            
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
