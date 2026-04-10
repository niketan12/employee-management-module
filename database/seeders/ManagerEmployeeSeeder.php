<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerEmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $managerRole = Role::firstWhere('name', 'Manager');
        if (! $managerRole) {
            $managerRole = Role::create(['name' => 'Manager', 'display_name' => 'Manager', 'description' => 'Manager role']);
        }

        $departments = Department::pluck('id', 'name')->all();

        $managerData = [
            ['name' => 'Michael Lee', 'employee_code' => 'M001', 'department_name' => 'Sales', 'email' => 'michael.lee@example.com'],
            ['name' => 'Sarah Miller', 'employee_code' => 'M002', 'department_name' => 'HR', 'email' => 'sarah.miller@example.com'],
            ['name' => 'David Clark', 'employee_code' => 'M003', 'department_name' => 'IT', 'email' => 'david.clark@example.com'],
            ['name' => 'Emily White', 'employee_code' => 'M004', 'department_name' => 'Marketing', 'email' => 'emily.white@example.com'],
            ['name' => 'Robert Hall', 'employee_code' => 'M005', 'department_name' => 'Finance', 'email' => 'robert.hall@example.com'],
            ['name' => 'Anna King', 'employee_code' => 'M006', 'department_name' => 'Operations', 'email' => 'anna.king@example.com'],
            ['name' => 'James Carter', 'employee_code' => 'M007', 'department_name' => 'Sales', 'email' => 'james.carter@example.com'],
            ['name' => 'Laura Scott', 'employee_code' => 'M008', 'department_name' => 'HR', 'email' => 'laura.scott@example.com'],
        ];

        foreach ($managerData as $data) {
            Employee::updateOrCreate([
                'employee_code' => $data['employee_code'],
            ], [
                'name' => $data['name'],
                'department_id' => $departments[$data['department_name']] ?? null,
                'manager_id' => null,
                'joined_date' => now()->subYears(2),
                'email' => $data['email'],
                'phone' => '0000000000',
                'role_id' => $managerRole->id,
            ]);
        }
    }
}
