<?php

namespace App\Imports;

use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class CustomerImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    // use SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        $user = User::create([
            'code'     => $row['code'],
            'name'    => $row['name'], 
            'email'    => $row['email'], 
            'address'    => $row['address'], 
            'phone'    => $row['phone'], 
            'password' => Hash::make(12345678),
            'status' => User::ACTIVE,
        ]);

        $user->assignRole('customer');
    }

    public function rules(): array
    {
        return [
            '*.email' => 'unique:users|required|string|email|max:255',
            '*.phone' => 'required|size:10|unique:users',
            '*.code' => 'unique:users|required',
            '*.address' => 'required|max:255',
            '*.name' => 'required|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.string' => 'Tên khách hàng không được chứa các ký tự đặc biệt.',
            'name.max' => 'Tên khách hàng không được phép quá 255 ký tự.',
            'name.required' => 'Tên khách hàng là trường bắt buộc.',
            'address.required' => 'Địa chỉ là trường bắt buộc.',
            'address.max' => 'Địa chỉ không được phép quá 255 ký tự.',
            'phone.required' => 'Số điện thoại là trường bắt buộc.',
            'phone.size' => 'Số điện thoại phải có 10 số.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.string' => 'Email không được chứa các ký tự đặc biệt.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'email.max' => 'Email không được phép quá 255 ký tự.',
            'code.unique' => 'Mã khách hàng đã tồn tại.',
            'code.required' => 'Mã khách hàng là trường bắt buộc.',
        ];
    }
}
