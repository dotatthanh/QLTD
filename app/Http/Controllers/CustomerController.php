<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->search) {
            $customers = User::role('customer')->where('status', 1)
            ->where('name', 'like', '%'.$request->search.'%')
            ->orwhere('code', $request->search)
            ->orwhere('phone', $request->search)->paginate(10);
        }
        else {
            $customers = User::role('customer')->where('status', 1)->paginate(10);
        }

        $data = [
            'search' => $request->search,
            'customers' => $customers,
        ];
        return view('customer.customer', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|size:10|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
        ];

        $messages = [
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
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'code' => 'KH'.strval(User::count()+1),
                'address' => $request->address,
                'phone' => $request->phone,
                'status' => User::ACTIVE,
            ]);
            $user->assignRole('customer');

            DB::commit();
            return redirect()->route('customers.index')->with('notificationAdd', 'Thêm khách hàng thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
            return redirect()->back()->with('notificationAdd', 'Thêm khách hàng thất bại!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);

        $data = [
            'customer' => $customer,
        ];
        return view('customer.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required|string|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:10',
        ];

        $messages = [
            'name.string' => 'Tên khách hàng không được dùng số hoặc các ký tự đặc biệt.',
            'name.max' => 'Tên khách hàng không được phép quá 255 ký tự.',
            'name.required' => 'Tên khách hàng là trường bắt buộc',
            'address.required' => 'Địa chỉ là trường bắt buộc',
            'address.max' => 'Địa chỉ không được phép quá 255 ký tự.',
            'phone.required' => 'Số điện thoại là trường bắt buộc',
            'phone.max' => 'Số điện thoại không được phép quá 10 ký tự.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.string' => 'Email không được chứa các ký tự đặc biệt.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'email.max' => 'Email không được phép quá 255 ký tự.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            User::find($id)->update([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            DB::commit();
            return redirect()->route('customers.index')->with('notificationUpdate', 'Cập nhật thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
            return redirect()->back()->with('notificationUpdate', 'Cập nhật thất bại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function deleteCustomer($id)
    {
        User::findOrFail($id)->update([
            'status' => -1,
        ]);

        return redirect()->route('customers.index')->with('notificationDelete', 'Xóa khách hàng thành công!');
    }

    public function exportCustomer(Request $request) {
        return Excel::download(new CustomerExport($request->all()), 'Khach_hang.xlsx');
    }
}
