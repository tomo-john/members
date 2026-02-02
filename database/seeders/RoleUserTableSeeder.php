<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// 追加
use App\Models\User;

class RoleUserTableSeeder extends Seeder
{
    public function run(): void
    {
        // admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],

            [
                'name'     => 'admin user',
                'password' => bcrypt('password'),
            ]
        );

        // regular user
        $regularUser = User::firstOrCreate(
            ['email' => 'test@gmail.com'],

            [
                'name'     => 'regular user',
                'password' => bcrypt('password'),
            ]
        );

        // admin userにadminロールのみ(id:1)を付与
        $adminUser->roles()->attach(1);

        // regular userにuserロールのみ(id:2)を付与
        $regularUser->roles()->attach(2);
    }
}
