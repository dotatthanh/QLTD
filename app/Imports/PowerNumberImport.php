<?php

namespace App\Imports;

use DB;
use App\Models\User;
use App\Models\Bill;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
// use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use DateTime;

class PowerNumberImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    // use SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public $data;

    public function model(array $row)
    {
        $explode = explode("/", $row['period']);
        $period = $explode[1].'-'.$explode[0].'-01';

        $customer = User::where('code', $row['code'])->first();
        if ($customer) {
            $bill = Bill::where('customer_id', $customer->id)->where('period', $period)->first();
            if (!$bill){
                if ($row['power_number'] <= 50) {
                    $price = $row['power_number'] * 1678;
                }
                elseif ($row['power_number'] >= 51 && $row['power_number'] <= 100) {
                    $price = 50 * 1678 + ($row['power_number'] - 50) * 1734;
                }
                elseif ($row['power_number'] >= 101 && $row['power_number'] <= 200) {
                    $price = 50 * 1678 + 50 * 1734 + ($row['power_number'] -100) * 2014;
                }
                elseif ($row['power_number'] >= 201 && $row['power_number'] <= 300) {
                    $price = 50 * 1678 + 50 * 1734 + 100 * 2014 + ($row['power_number'] - 200) * 2536;
                }
                elseif ($row['power_number'] >= 301 && $row['power_number'] <= 400) {
                    $price = 50 * 1678 + 50 * 1734 + 100 * 2014 + 100 * 2536 + ($row['power_number'] - 300) * 2834;
                }
                elseif ($row['power_number'] >= 401) {
                    $price = 50 * 1678 + 50 * 1734 + 100 * 2014 + 100 * 2536 + 100 * 2834 + ($row['power_number'] - 400) * 2927;
                }

                Bill::create([
                    'customer_id' => $customer->id,
                    'code' => 'HD'.strval(Bill::count()+1),
                    'power_number' => $row['power_number'],
                    'price' => $price,
                    'debit' => $price,
                    'period' => $period,
                    'status' => Bill::UNPAID,
                ]);
            }
        }
    }
    
    // public function collection(Collection $rows)
    // {
    //     $this->data = $rows;
    // }


    public function rules(): array
    {
        return [
            '*.power_number' => 'required|min:1',
            '*.code' => 'required',
            '*.name' => 'required|string|max:255',
            '*.period' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.string' => 'Tên khách hàng không được chứa các ký tự đặc biệt.',
            'name.max' => 'Tên khách hàng không được phép quá 255 ký tự.',
            'name.required' => 'Tên khách hàng là trường bắt buộc.',
            'code.required' => 'Mã khách hàng là trường bắt buộc.',
            'period.required' => 'Kỳ thu là trường bắt buộc.',
            'power_number.required' => 'Số điện là trường bắt buộc.',
            'power_number.min' => 'Số điện ít nhất phải bằng 1.',
        ];
    }
}
