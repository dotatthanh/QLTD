<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'address' => 'required|max:255',
            'phone' => 'required|size:10|unique:users',
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
            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'password.string' => 'Mật khẩu không được chứa các ký tự đặc biệt.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min' => 'Mật khẩu phải ít nhất 8 ký tự.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|confirmed|min:8',
        //     'address' => 'required|max:255',
        //     'phone' => 'required|max:10',
        // ]);


        if ($request->is_customer) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'code' => 'KH'.strval(User::count()+1),
                'address' => $request->address,
                'phone' => $request->phone,
                'status' => User::ACTIVE,
            ]);
            $user->assignRole('customer');
        }
        else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'code' => 'NV'.strval(User::count()+1),
                'address' => $request->address,
                'phone' => $request->phone,
                'status' => User::UNACTIVE,
            ]);
            $user->assignRole('staff');
        }

        // Auth::login($user);

        // event(new Registered($user));

        // return redirect(RouteServiceProvider::HOME);
        return redirect('/');
    }
}
