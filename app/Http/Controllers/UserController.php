<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserController extends Controller
{
    public function changePassword()
    {
        return view('auth.change-password');
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

        if ($request->permission) {
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

    public function test()
    {
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

    }
}
