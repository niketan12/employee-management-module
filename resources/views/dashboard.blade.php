@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h1 class="h4">Dashboard</h1>
                <p>Welcome back, {{ auth()->user()->name }}. Use the menu to manage employees.</p>
            </div>
        </div>
    </div>
</div>
@endsection
