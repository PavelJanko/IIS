<div class="card text-white mb-3 text-center h-100 text-uppercase">
    <div class="card-header bg-dark font-weight-bold">Administrace</div>
    <div class="card-body p-0 h-100">
        <nav class="nav nav-pills flex-column h-100">
            <a class="nav-link{{ isInRouteName('devices') }}" href="{{ route('devices.index') }}">Zařízení</a>
            <a class="nav-link{{ isInRouteName('repairs') }}" href="{{ route('repairs.index') }}">Opravy</a>
            <a class="nav-link{{ isInRouteName('departments') }}" href="{{ route('departments.index') }}">Ústavy</a>
            <a class="nav-link{{ isInRouteName('rooms') }}" href="{{ route('rooms.index') }}">Místnosti</a>
            {{-- Display the menu item for employee management only if the user has sufficient permissions --}}
            @can('manage employees')
                <a class="nav-link{{ isInRouteName('employees') }}" href="{{ route('employees.index') }}">Zaměstnanci</a>
            @endcan
        </nav>
    </div>
</div>
