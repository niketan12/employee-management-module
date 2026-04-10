@extends('layouts.app')

@section('content')
<!-- CDNs -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css" />

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.min.js"></script>

<style>
body {
    background-color: #f8f9fa;
}
.card {
    background-color: white;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}
.form-label .text-danger {
    font-weight: 600;
    margin-left: 2px;
    display: inline;
}
.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #dc3545 !important;
}
.text-danger {
    color: #dc3545 !important;
    font-size: 0.825rem;
    display: block;
    margin-top: 0.25rem;
}
.alert-danger ul {
    margin-bottom: 0;
    margin-left: 1rem;
}
.alert-danger ul li {
    margin-bottom: 0.25rem;
}
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Employees List</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
            <i class="bi bi-plus-circle me-2"></i> Add Employee
        </button>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" id="searchName" class="form-control" placeholder="Search by Name">
                </div>
                <div class="col-md-3">
                    <select id="filterDepartment" name="department_id" class="form-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="filterManager" name="manager_id" class="form-select">
                        <option value="">All Managers</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" id="dateRange" class="form-control" placeholder="Select Date Range">
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="employeesTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Employee Code</th>
                            <th>Department</th>
                            <th>Manager</th>
                            <th>Joined Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employeeRow)
                        @php 
                        //pr($employeeRow);
                        @endphp
                            <tr>
                                <td><a href="#" class="text-primary">{{ $employeeRow->name }}</a></td>
                                <td>{{ $employeeRow->employee_code }}</td>
                                <td>{{ $employeeRow->department_name ?? '-' }}</td>
                                <td>{{ $employeeRow->role_name === config('constants.roles.manager') ? 'Self' : ($employeeRow->manager_name ?? '-') }}</td>
                                <td>{{ optional($employeeRow->joined_date)->format('m/d/Y') ?? '-' }}</td>
                                <td>
                                    @if($employeeRow->role_id != 4)
                                    <button class="btn btn-sm btn-outline-primary me-2 edit-btn" title="Edit" data-id="{{ $employeeRow->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-btn" title="Delete" data-id="{{ $employeeRow->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @else
                                    <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No employees found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addEmployeeForm">
                <div class="modal-body">
                    <div id="formErrors" class="alert alert-danger d-none" role="alert"></div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fullName" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fullName" name="name" required>
                            <small class="text-danger d-none" id="error-name"></small>
                        </div>
                        <div class="col-md-6">
                            <label for="employeeCode" class="form-label">Employee Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="employeeCode" name="employee_code" required>
                            <small class="text-danger d-none" id="error-employee_code"></small>
                        </div>
                        <div class="col-md-6">
                            <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
                            <select class="form-select" id="department" name="department_id" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger d-none" id="error-department_id"></small>
                        </div>
                        <div class="col-md-6">
                            <label for="manager" class="form-label">Manager <span class="text-danger">*</span></label>
                            <select class="form-select" id="manager" name="manager_id" required>
                                <option value="">Select Manager</option>
                            </select>
                            <small class="text-danger d-none" id="error-manager_id"></small>
                        </div>
                        <div class="col-md-6">
                            <label for="joiningDate" class="form-label">Joining Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="joiningDate" name="joined_date" required>
                            <small class="text-danger d-none" id="error-joined_date"></small>
                        </div>
                        <div class="col-md-6">
                            <label for="emailAddress" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="emailAddress" name="email" required>
                            <small class="text-danger d-none" id="error-email"></small>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                            <small class="text-danger d-none" id="error-phone"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#employeesTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: "",
            searchPlaceholder: "Search employees..."
        }
    });

    $('#dateRange').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $('#searchName').on('keyup', function() {
        $('#employeesTable').DataTable().search($(this).val()).draw();
    });

    $('#filterDepartment').on('change', function() {
        const selected = $(this).find('option:selected').text();
        $('#employeesTable').DataTable().column(2).search(selected === 'All Departments' ? '' : selected).draw();
    });

    $('#filterManager').on('change', function() {
        const selected = $(this).find('option:selected').text();
        $('#employeesTable').DataTable().column(3).search(selected === 'All Managers' ? '' : selected).draw();
    });

    // Handle department change in modal
    $('#department').on('change', function() {
        const departmentId = $(this).val();
        const managerSelect = $('#manager');
        
        if (departmentId) {
            $.ajax({
                url: '{{ route("employees.managers.by-department") }}',
                method: 'GET',
                data: { department_id: departmentId },
                success: function(data) {
                    managerSelect.empty();
                    managerSelect.append('<option value="">Select Manager</option>');
                    $.each(data, function(key, manager) {
                        managerSelect.append('<option value="' + manager.id + '">' + manager.name + '</option>');
                    });
                },
                error: function() {
                    managerSelect.empty();
                    managerSelect.append('<option value="">Select Manager</option>');
                }
            });
        } else {
            managerSelect.empty();
            managerSelect.append('<option value="">Select Manager</option>');
        }
    });

    // Clear form errors when modal is opened
    $('#addEmployeeModal').on('show.bs.modal', function () {
        $('#addEmployeeForm')[0].reset();
        $('#formErrors').addClass('d-none').html('');
        $('small.text-danger').addClass('d-none').text('');
    });

    // Validate form fields
    function validateForm() {
        let isValid = true;
        const errors = {};
        
        // Clear previous error messages
        $('#formErrors').addClass('d-none').html('');
        $('.text-danger.d-none').each(function() {
            $(this).addClass('d-none').text('');
        });

        // Get form values
        const name = $('#fullName').val().trim();
        const employeeCode = $('#employeeCode').val().trim();
        const department_id = $('#department').val().trim();
        const manager_id = $('#manager').val().trim();
        const joiningDate = $('#joiningDate').val().trim();
        const email = $('#emailAddress').val().trim();
        const phone = $('#phone').val().trim();

        // Validate all fields
        if (!name) {
            errors.name = 'Full Name is required';
            isValid = false;
        }
        if (!employeeCode) {
            errors.employee_code = 'Employee Code is required';
            isValid = false;
        }
        if (!department_id) {
            errors.department_id = 'Department is required';
            isValid = false;
        }
        if (!manager_id) {
            errors.manager_id = 'Manager is required';
            isValid = false;
        }
        if (!joiningDate) {
            errors.joined_date = 'Joining Date is required';
            isValid = false;
        }
        if (!email) {
            errors.email = 'Email Address is required';
            isValid = false;
        } else if (!isValidEmail(email)) {
            errors.email = 'Please enter a valid email address';
            isValid = false;
        }
        if (!phone) {
            errors.phone = 'Phone Number is required';
            isValid = false;
        }

        // Display error messages
        if (!isValid) {
            let errorHtml = '<strong>Please fix the following errors:</strong><ul>';
            $.each(errors, function(key, message) {
                errorHtml += '<li>' + message + '</li>';
                const errorElement = $('#error-' + key);
                if (errorElement.length) {
                    errorElement.removeClass('d-none').text(message);
                }
            });
            errorHtml += '</ul>';
            $('#formErrors').removeClass('d-none').html(errorHtml);
        }

        return isValid;
    }

    // Email validation helper
    function isValidEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    $('#addEmployeeForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate form before submission
        if (!validateForm()) {
            return false;
        }

        $.ajax({
            url: '{{ route("employees.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#addEmployeeModal').modal('hide');
                $('#addEmployeeForm')[0].reset();
                $('#formErrors').addClass('d-none').html('');
                location.reload(); // Reload to update table
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors from server
                    const errors = xhr.responseJSON.errors;
                    let errorHtml = '<strong>Validation errors:</strong><ul>';
                    $.each(errors, function(key, messages) {
                        errorHtml += '<li>' + messages[0] + '</li>';
                        const errorElement = $('#error-' + key);
                        if (errorElement.length) {
                            errorElement.removeClass('d-none').text(messages[0]);
                        }
                    });
                    errorHtml += '</ul>';
                    $('#formErrors').removeClass('d-none').html(errorHtml);
                } else {
                    $('#formErrors').removeClass('d-none').html('<strong>Error:</strong> An error occurred while saving the employee. Please try again.');
                }
            }
        });
    });
});
</script>
@endsection
