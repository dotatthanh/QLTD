<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RevenueExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $request;
    
    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        if (array_key_exists('name', $this->request)) {
            $customers = User::role('customer')->where('status', User::ACTIVE)->where('name', 'like', '%'.$this->request['name'].'%')->get();
            return $customers;
        }

        $customers = User::role('customer')->where('status', User::ACTIVE)->get();

        return $customers;
    }

    public function headings(): array {
        return [
        	'Mã khách hàng',
            'Họ và tên',
        	'Địa chỉ',
            'Email',    
            'Số điện thoại',    
            'Số điện',    
            'Số nợ',    
            'Doanh thu',    
        ];
    }

    public function map($user): array {
        return [
            $user->code,
            $user->name,
            $user->address,
            $user->email,
            $user->phone,
            $user->power_number,
            $user->debit,
            $user->revenue,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,            
            'C' => 50,            
            'D' => 20,            
            'E' => 30,            
            'F' => 15,            
            'G' => 15,            
            'H' => 15,            
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
