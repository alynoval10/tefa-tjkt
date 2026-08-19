<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(
            [
                'name' => 'admin',
                'guard_name' => 'web',
            ]
        );

        $user = User::firstOrCreate(
            [
                'email' => 'admin@smkn1krangkeng.sch.id',
            ],
            [
                'name' => 'admin',
                'password' => Hash::make('123456'),
            ]
        );

        $user->update([
            'role' => 'admin',
        ]);

        $user->syncRoles([$role]);
    }
}