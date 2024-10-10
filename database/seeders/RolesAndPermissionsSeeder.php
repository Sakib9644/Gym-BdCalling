<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'manage trainers', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'schedule classes', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'view schedules', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'manage profile', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'book classes', 'guard_name' => 'api']);

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        $adminRole->givePermissionTo(['manage trainers', 'schedule classes']);

        $trainerRole = Role::firstOrCreate(['name' => 'trainer', 'guard_name' => 'api']);
        $trainerRole->givePermissionTo('view schedules');

        $traineeRole = Role::firstOrCreate(['name' => 'trainee', 'guard_name' => 'api']);
        $traineeRole->givePermissionTo(['manage profile', 'book classes']);
    }
}
