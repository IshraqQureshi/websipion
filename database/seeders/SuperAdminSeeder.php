<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'role' => '3',
        // 'social_id'=>'',
        'name' => 'Super Admin',
        'email'=>'superadmin@gmail.com',
        'mobile'=>'1234',
        'password' => Hash::make('Super@Admin'),
        'status'=>'1',
        'coins'=>'4000',
        'address'=>'',
        'city'=> '',
        'state'=>'',
        'country'=> '',
        'zipCode' => '',
        'default_language' => ''
        ]);
    }
}
