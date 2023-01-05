<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => 'power@123',
                'cpf' => '57043521033',
            ],
        ];

        foreach ($admins as $admin) {
            $admin['password'] = \Hash::make($password = $admin['password']);

            dump("User: {$admin['name']}");
            dump("Password: {$password}");
            dump("CPF: {$admin['cpf']}");

            User::updateOrCreate([
                'email' => $admin['email'],
            ], $admin);
        }
    }
}
