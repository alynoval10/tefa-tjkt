<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'bendahara',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'guru',
            'guard_name' => 'web',
        ]);
    }
}