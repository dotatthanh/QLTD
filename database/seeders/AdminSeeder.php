<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => "Admin",
            'email' => "admin@gmail.com",
            'password' => Hash::make(123123123),
            // 'code' => 'NV'.strval(User::count()+1),
            'code' => 'ADMIN',
            'address' => "Trung Hòa, Cầu Giấy, Hà Nội",
            'phone' => '0369852147',
            'status' => 1,
        ]);

        $user->assignRole('admin');
    }
}
