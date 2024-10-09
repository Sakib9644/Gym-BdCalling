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
        Permission::create(['name' => 'manage trainers']);
        Permission::create(['name' => 'schedule classes']);
        Permission::create(['name' => 'view schedules']);
        Permission::create(['name' => 'manage profile']);
        Permission::create(['name' => 'book classes']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(['manage trainers', 'schedule classes']);

        $trainerRole = Role::create(['name' => 'trainer']);
        $trainerRole->givePermissionTo('view schedules');

        $traineeRole = Role::create(['name' => 'trainee']);
        $traineeRole->givePermissionTo(['manage profile', 'book classes']);
    }
}
