<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create(
            [
                'username' => 'Admin',
                'email' => 'Admin@email.com',
                'password' => Hash::make('admin'),
                'lang' => 'en',
            ]
        );
        $user->assignRole('Admin');
        User::create(
            [
                'username' => 'Cashier',
                'email' => 'cashier@email.com',
                'password' => Hash::make('cashier'),
                'lang' => 'en',
            ]
        );
    }
}
