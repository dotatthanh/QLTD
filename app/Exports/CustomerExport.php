<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths, WithStyles
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
        if (array_key_exists('search', $this->request)) {
            $customers = User::role('customer')->where('status', User::ACTIVE)
	            ->where('name', 'like', '%'.$this->request['search'].'%')
	            ->orwhere('code', $this->request['search'])
	            ->orwhere('phone', $this->request['search'])->get();
        	
        	return $customers;
        }
        $customers = User::role('customer')->where('status', User::ACTIVE)->get();

        return $customers;
    }

    public function headings(): array {
        return [
        	'Mã khách hàng',
            'Họ và tên',
            'Số điện thoại',    
        	'Địa chỉ',
        ];
    }

    public function map($user): array {
        return [
            $user->code,
            $user->name,
            $user->phone,
            $user->address,
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
