<aside class="bg-white border-end p-3" style="width: 250px;">
    <h5 class="mb-3">Navigation</h5>
    <div class="list-group">
        <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action @activeRoute('dashboard')">Dashboard</a>
        @auth
            <a href="{{ route('employees.index') }}" class="list-group-item list-group-item-action @activeRoute('employees.*')">Employees</a>
        @endauth
    </div>
</aside>
