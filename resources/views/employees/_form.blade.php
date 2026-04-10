<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>{{ isset($employee) && $employee->exists ? 'Edit Employee' : 'Add Employee' }}</span>
        @if(isset($employee) && $employee->exists)
            <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-secondary">Cancel</a>
        @endif
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($employee) && $employee->exists ? route('employees.update', $employee) : route('employees.store') }}">
            @csrf
            @if(isset($employee) && $employee->exists)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input name="name" value="{{ old('name', $employee->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Employee Code</label>
                <input name="employee_code" value="{{ old('employee_code', $employee->employee_code ?? '') }}" class="form-control @error('employee_code') is-invalid @enderror" placeholder="E001">
                @error('employee_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <input name="department" value="{{ old('department', $employee->department ?? '') }}" class="form-control @error('department') is-invalid @enderror" placeholder="Sales">
                @error('department')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Manager</label>
                <input name="manager" value="{{ old('manager', $employee->manager ?? '') }}" class="form-control @error('manager') is-invalid @enderror" placeholder="Michael Lee">
                @error('manager')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Joining Date</label>
                <input type="date" name="joined_date" value="{{ old('joined_date', optional($employee->joined_date)->format('Y-m-d') ?? '') }}" class="form-control @error('joined_date') is-invalid @enderror">
                @error('joined_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $employee->email ?? '') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input name="phone" value="{{ old('phone', $employee->phone ?? '') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="(123) 456-7890">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2 justify-content-end">
                @if(isset($employee) && $employee->exists)
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
                @endif
                <button type="submit" class="btn btn-primary">{{ isset($employee) && $employee->exists ? 'Save Changes' : 'Save Employee' }}</button>
            </div>
        </form>
    </div>
</div>
