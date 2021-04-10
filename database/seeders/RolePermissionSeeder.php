<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_staff = Role::create(['name' => 'staff']);
        $role_customer = Role::create(['name' => 'customer']);
		$permission = Permission::create(['name' => 'add customer']);
        $permission = Permission::create(['name' => 'edit customer']);
        $permission = Permission::create(['name' => 'delete customer']);
        $permission = Permission::create(['name' => 'add bill']);
        $permission = Permission::create(['name' => 'edit bill']);
        $permission = Permission::create(['name' => 'delete bill']);
    }
}
