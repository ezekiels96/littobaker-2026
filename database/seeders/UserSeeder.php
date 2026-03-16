<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Ezekiel Sung',
                'email'    => 'ezekielsung96@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'Joanne Nguyen',
                'email'    => 'nguyenjoanne98@gmail.com',
                'password' => Hash::make('potatocorner5!'),
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }
    }
}
