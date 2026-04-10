@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="mb-0">Use the right panel to add a new employee. After saving, the employee will appear in the list.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        @include('employees._form', ['employee' => $employee])
    </div>
</div>
@endsection
