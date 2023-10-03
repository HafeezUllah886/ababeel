<?php

namespace Database\Seeders;

use App\Models\accounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class accountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            [
                'title' => 'Walk-in Customer',
                'type' => 'Customer',
                'isActive' => 1,
            ],
            [
                'title' => 'Cash',
                'type' => 'Business',
                'cat' => 'Cash',
                'isActive' => 1
            ]
        ];

        foreach ($accounts as $key => $account){
            accounts::create($account);
        }
    }
}
