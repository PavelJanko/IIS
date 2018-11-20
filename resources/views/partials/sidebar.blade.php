<div class="card text-white bg-dark mb-3 text-center">
    <div class="card-header font-weight-bold text-uppercase">Administrace</div>
    <div class="card-body p-0">
        <nav class="nav nav-pills flex-column">
            <a class="nav-link{{ isActiveRoute('overview') }}" href="{{ route('overview') }}">Přehled</a>
            <a class="nav-link{{ isInRouteName('devices') }}" href="{{ route('devices.index') }}">Zařízení</a>
            <a class="nav-link{{ isInRouteName('repairs') }}" href="{{ route('repairs.index') }}">Opravy</a>
            <a class="nav-link{{ isInRouteName('departments') }}" href="{{ route('departments.index') }}">Ústavy</a>
            <a class="nav-link{{ isInRouteName('rooms') }}" href="{{ route('rooms.index') }}">Místnosti</a>
            {{-- Display the menu item for employee management only if the user has sufficient permissions --}}
            @role('administrator')
                <a class="nav-link{{ isInRouteName('employees') }}" href="{{ route('employee.index') }}">Zaměstnanci</a>
            @endrole
        </nav>
    </div>
</div>
