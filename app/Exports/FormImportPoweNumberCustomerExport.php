<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class FormImportPoweNumberCustomerExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $customers = User::role('customer')->where('status', User::ACTIVE)->get();

        return $customers;
    }

    public function headings(): array {
        return [
        	'code',
            'name',
            'power_number',    
        	'period',
        ];
    }

    public function map($user): array {
        return [
            $user->code,
            $user->name,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,            
            'C' => 20,            
            'D' => 50,            
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
