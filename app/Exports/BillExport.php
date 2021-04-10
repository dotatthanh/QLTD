<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Bill;
use DateTime;

class BillExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths, WithStyles
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
        if(array_key_exists('search', $this->request)) {
            $bills = Bill::with('user')
            	->where('code', 'like','%'.$this->request['search']. '%')
            	->get();
        	return $bills;
        }
        $bills = Bill::with('user')->get();

        return $bills;
    }

    public function headings(): array {
        return [
        	'Mã HĐ',
            'Mã KH',
        	'Tên khách hàng',
            'Số điện',    
            'Số tiền',    
            'Số tiền thu',    
            'Số tiền trả lại',    
            'Số tiền nợ cước',    
            'Kỳ thu',    
            'Trạng thái',    
        ];
    }

    public function map($bill): array {
        return [
            $bill->code,
            $bill->user->code,
            $bill->user->name,
            $bill->power_number,
            $bill->price,
            $bill->proceeds,
            $bill->amount_return,
            $bill->debit,
            date_format(new DateTime($bill->period), 'm/Y'),
            $bill->status ? 'Đã thu' : 'Chưa thu',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 10,            
            'C' => 30,            
            'D' => 10,            
            'E' => 10,            
            'F' => 10,            
            'G' => 15,            
            'H' => 15,            
            'I' => 10,            
            'K' => 10,            
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
