<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'type' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' =>  Hash::make('password'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
