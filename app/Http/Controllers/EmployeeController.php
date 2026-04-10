<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $employees = Employee::with(['role'])
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->leftJoin('employees as managers', 'employees.manager_id', '=', 'managers.id')
            ->select('employees.*', 'departments.name as department_name', 'managers.name as manager_name')
            ->where('employees.is_deleted', 0)
            ->when($request->filled('search'), fn ($query) => $query->where('employees.name', 'like', '%' . $request->search . '%'))
            ->when($request->filled('department_id'), fn ($query) => $query->where('employees.department_id', $request->department_id))
            ->when($request->filled('manager_id'), fn ($query) => $query->where('employees.manager_id', $request->manager_id))
            ->orderBy('employees.id', 'desc')
            ->paginate(config('constants.pagination.default'))
            ->withQueryString();
    
        $departments = Department::orderBy('name')->get();
        $managers = Employee::whereHas('role', fn ($query) => $query->where('name', config('constants.roles.manager')))
            ->where('is_deleted', 0)
            ->orderBy('name')
            ->get();

        return view('employees.index', compact('employees', 'departments', 'managers'));
    }

    public function create(): View
    {
        return view('employees.create', ['employee' => new Employee()]);
    }

    public function store(EmployeeRequest $request): RedirectResponse
    {
        $employeeRole = Role::firstWhere('name', config('constants.roles.employee'));

        Employee::create(array_merge($request->validated(), [
            'role_id' => $employeeRole?->id,
        ]));

        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }

    public function edit(Employee $employee): View
    {
        $employees = Employee::with(['role'])
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->leftJoin('employees as managers', 'employees.manager_id', '=', 'managers.id')
            ->select('employees.*', 'departments.name as department_name', 'managers.name as manager_name')
            ->where('employees.is_deleted', 0)
            ->orderBy('employees.id', 'desc')
            ->paginate(config('constants.pagination.default'));
        $departments = Department::orderBy('name')->get();
        $managers = Employee::whereHas('role', fn ($query) => $query->where('name', config('constants.roles.manager')))
            ->where('is_deleted', 0)
            ->orderBy('name')
            ->get();

        return view('employees.index', compact('employees', 'departments', 'managers', 'employee'));
    }

    public function getEmployeeData(Employee $employee)
    {
        if ($employee->is_deleted) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        return response()->json([
            'id' => $employee->id,
            'name' => $employee->name,
            'employee_code' => $employee->employee_code,
            'department_id' => $employee->department_id,
            'manager_id' => $employee->manager_id,
            'joined_date' => $employee->joined_date ? $employee->joined_date->format('Y-m-d') : '',
            'email' => $employee->email,
            'phone' => $employee->phone,
            'role_id' => $employee->role_id,
        ]);
    }

    public function softDelete(Employee $employee)
    {
        $employee->update(['is_deleted' => 1]);
        return response()->json(['success' => true]);
    }

    public function update(EmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $employee->update($request->validated());

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Request $request, Employee $employee)
    {
        $employee->update(['is_deleted' => 1]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function getManagersByDepartment(Request $request)
    {
        $departmentId = $request->query('department_id');
        $managers = Employee::where('department_id', $departmentId)
            ->where('is_deleted', 0)
            ->whereHas('role', fn ($query) => $query->where('name', config('constants.roles.manager')))
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($managers);
    }
}
