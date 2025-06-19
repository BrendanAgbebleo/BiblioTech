<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaffUser;
use Illuminate\Support\Facades\Hash;

class FirstAdminSeeder extends Seeder
{
    public function run()
    {
        if (!StaffUser::where('uid', 'admin01')->exists()) {
            StaffUser::create([
                'uid' => 'admin01',
                'name' => 'First Admin',
                'email' => 'admin@example.com',
                'phone' => '1234567890',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]);
        }
    }
}