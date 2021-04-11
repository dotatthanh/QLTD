<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function changePassword()
    {
        return view('auth.change-password');
    }

    public function changePasswordStore(Request $request)
    {
        $rules = [
            'password_old' => 'required|string|min:8',
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required|string|min:8',
        ];

        $messages = [
            'password_old.required' => 'Mật khẩu cũ là trường bắt buộc.',
            'password_confirmation.required' => 'Xác nhận mật khẩu là trường bắt buộc.',
            'password_old.string' => 'Mật khẩu cũ không được chứa các ký tự đặc biệt.',
            'password_confirmation.string' => 'Xác nhận mật khẩu không được chứa các ký tự đặc biệt.',
            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'password.string' => 'Mật khẩu không được chứa các ký tự đặc biệt.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min' => 'Mật khẩu phải ít nhất 8 ký tự.',
            'password_old.min' => 'Mật khẩu cũ phải ít nhất 8 ký tự.',
            'password_confirmation.min' => 'Xác nhận mật khẩu phải ít nhất 8 ký tự.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        if (Hash::check($request->password_old, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            return redirect()->back()->with('notificationSuccess', 'Đổi mật khẩu thành công!');
        }
        else {
            return redirect()->back()->with('notificationFail', 'Mật khẩu cũ không đúng!');
        }
    }

    public function role()
    {
        $roles = Role::all();

        $data = [
            'roles' => $roles,
        ];
        return view('permission.role', $data);
    }

    public function editPermission($id)
    {
        $role = Role::find($id);
        $permissions = Permission::with('roles')->get();

        $data = [
            'role' => $role,
            'permissions' => $permissions,
        ];
        return view('permission.edit', $data);
    }

    public function updatePermission(Request $request, $id)
    {
        $role = Role::find($id);

        $role->permissions()->detach();

        if ($request->permissions) {
            foreach ($request->permissions as $permission => $value) {
                $permission = Permission::find($permission);
                $role->givePermissionTo($permission);
            }
        }

        return redirect()->route('edit-permission', $id)->with('notificationEditPermission', 'Đã lưu thành công!');
    }

    public function staff()
    {
        $users = User::role('staff')->paginate(10);

        $data = [
            'users' => $users,
        ];

        return view('staff.index', $data);
    }

    public function active($id)
    {
        User::findOrFail($id)->update([
            'status' => 1,
        ]);

        return redirect()->route('staff')->with('notificationActive', 'Kích hoạt thành công!');
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->update([
            'status' => -1,
        ]);

        return redirect()->route('staff')->with('notificationDelete', 'Xóa thành công!');
    }

    // public function test()
    // {
        // $role_admin = Role::where('name', 'admin')->first();
        // $role_staff = Role::where('name', 'staff')->first();

        // $permission_add_customer = Permission::where('name', 'add customer')->first();
        // $permission_edit_customer = Permission::where('name', 'edit customer')->first();
        // $permission_delete_customer = Permission::where('name', 'delete customer')->first();
        // $permission_add_bill = Permission::where('name', 'add bill')->first();
        // $permission_edit_bill = Permission::where('name', 'edit bill')->first();
        // $permission_delete_bill = Permission::where('name', 'delete bill')->first();

        // $role_admin->givePermissionTo($permission_add_customer);
        // $role_admin->givePermissionTo($permission_edit_customer);
        // $role_admin->givePermissionTo($permission_delete_customer);
        // $role_admin->givePermissionTo($permission_add_bill);
        // $role_admin->givePermissionTo($permission_edit_bill);
        // $role_admin->givePermissionTo($permission_delete_bill);

        // $role_staff->givePermissionTo($permission_add_customer);
        // $role_staff->givePermissionTo($permission_edit_customer);
        // $role_staff->givePermissionTo($permission_add_bill);
        // $role_staff->givePermissionTo($permission_edit_bill);

    // }
}
