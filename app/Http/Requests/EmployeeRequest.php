<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'employee_code' => ['required', 'string', 'max:50', 'unique:employees,employee_code,' . $employeeId],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'manager_id' => ['required', 'integer', 'exists:employees,id'],
            'joined_date' => ['required', 'date'],
            'email' => ['required', 'email', 'max:255', 'unique:employees,email,' . $employeeId],
            'phone' => ['required', 'string', 'max:25'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Full Name is required',
            'employee_code.required' => 'Employee Code is required',
            'employee_code.unique' => 'This Employee Code is already taken',
            'department_id.required' => 'Department is required',
            'department_id.exists' => 'Selected department is invalid',
            'manager_id.required' => 'Manager is required',
            'manager_id.exists' => 'Selected manager is invalid',
            'joined_date.required' => 'Joining Date is required',
            'email.required' => 'Email Address is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This Email Address is already registered',
            'phone.required' => 'Phone Number is required',
        ];
    }
}
