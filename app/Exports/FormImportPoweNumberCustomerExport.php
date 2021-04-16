<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FormImportPoweNumberCustomerExport implements WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array {
        return [
        	'code',
            'name',
            'power_number',    
        	'period',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,            
            'C' => 15,            
            'D' => 15,            
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
