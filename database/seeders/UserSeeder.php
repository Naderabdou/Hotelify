<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Users admin

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);

        $admin->assignRole('admin');


        // Users manager

        $user = User::create([
            'name' => 'guest',
            'email' => 'guest@gmail.com',
            'password' => 'password',
        ]);
        $user->assignRole('user');
    }
}
