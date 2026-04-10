<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::updateOrCreate([
            'name' => config('constants.roles.admin'),
        ], [
            'display_name' => 'Administrator',
            'description' => 'Full platform administration access.',
        ]);

        $userRole = Role::updateOrCreate([
            'name' => config('constants.roles.user'),
        ], [
            'display_name' => 'User',
            'description' => 'Standard authenticated user.',
        ]);

        $employeeRole = Role::updateOrCreate([
            'name' => config('constants.roles.employee'),
        ], [
            'display_name' => 'Employee',
            'description' => 'Standard employee role.',
        ]);

        $managerRole = Role::updateOrCreate([
            'name' => config('constants.roles.manager'),
        ], [
            'display_name' => 'Manager',
            'description' => 'Manager role for employee managers.',
        ]);

        $hrRole = Role::updateOrCreate([
            'name' => config('constants.roles.hr'),
        ], [
            'display_name' => 'HR',
            'description' => 'Human resources role.',
        ]);

        $oaRole = Role::updateOrCreate([
            'name' => config('constants.roles.oa'),
        ], [
            'display_name' => 'OA',
            'description' => 'Operations assistant role.',
        ]);
    }
}
