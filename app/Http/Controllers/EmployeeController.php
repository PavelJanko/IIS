<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:manage employees'])->except(['getGraphData']);
    }

    /**
     * Display a listing of the employees.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $employees = Employee::orderBy('created_at', 'desc')->get();

        $collapsibleRows = [];

        $tableHeaders = ['', 'Jméno', 'Uživatelské jméno', 'E-mail', 'Datum přidání', 'Akce'];
        $tableRows = [];

        for ($i = 0; $i < $employees->count(); $i++) {
            $tableRows[$i] = [
                $employees[$i]->id,
                $employees[$i]->name,
                $employees[$i]->username,
                $employees[$i]->email,
                $employees[$i]->created_at->format('d. m. Y')
            ];

            $collapsibleRowTitles = ['Role', 'Ústav', 'Místnost', 'Telefonní číslo', 'Ulice', 'Číslo popisné', 'Město', 'PSČ'];

            $collapsibleRowValues = [
                $employees[$i]->getRoleNames()->count() === 0 ? 'Zaměstnanec' : ucfirst($employees[$i]->getRoleNames()->first()),
                $employees[$i]->department === NULL ? 'Žádný' : '<a href="' . route("departments.show", $employees[$i]->department->id) . '">' . $employees[$i]->department->shortcut . '</a>',
                $employees[$i]->room === NULL ? 'Žádná' : $employees[$i]->room->label,
                $employees[$i]->phone_number === NULL ? 'Nevyplněno' : $employees[$i]->phone_number,
                $employees[$i]->street === NULL ? 'Nevyplněno' : $employees[$i]->street,
                $employees[$i]->building_number === NULL ? 'Nevyplněno' : $employees[$i]->building_number,
                $employees[$i]->city === NULL ? 'Nevyplněno' : $employees[$i]->city,
                $employees[$i]->zip_code === NULL ? 'Nevyplněno' : $employees[$i]->zip_code
                
            ];

            for ($j = 0; $j < count($collapsibleRowTitles); $j++)
                $collapsibleRows[$i][$j] = [$collapsibleRowTitles[$j], $collapsibleRowValues[$j]];
        }

        return view('employees.index')->with([
            'collapsibleRows' => $collapsibleRows,
            'employees' => $employees,
            'pageTitle' => 'Seznam zaměstnanců',
            'tableHeaders' => $tableHeaders,
            'tableRows' => $tableRows,
        ]);
    }

    /**
     * Display the specified employee.
     *
     * @param Employee $employee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Employee $employee)
    {
        return view ('employees.show')->with([
            'employee' => $employee,
            'pageTitle' => 'Detail zaměstnance' . $employee->name,
        ]);
    }

    /**
     * Show the form for editing the specified employee.
     *
     * @param Employee $employee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all();

        $roles = ['Zaměstnanec', 'Manažer'];

        if (Auth::user()->hasRole('administrátor'))
            array_push($roles, 'Administrátor');

        $rooms = Room::all();

        return view ('employees.edit')->with([
            'departments' => $departments,
            'employee' => $employee,
            'pageTitle' => 'Upravit zaměstnance' . $employee->name,
            'roles' => $roles,
            'rooms' => $rooms
        ]);
    }

    /**
     * Update the specified employee in storage.
     *
     * @param Request $request
     * @param Employee $employee
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Employee $employee)
    {
        $this->validate($request, [
            'department_id' => 'required|numeric|exists:departments,id',
            'room_id' => 'nullable|numeric|exists:rooms,id',
            'name' => 'required|string',
            'username' => $employee->username === $request->input('username') ? 'required|string' : 'required|unique:employees|string',
            'email' => $employee->email === $request->input('email') ? 'required|email' : 'required|unique:employees|email',
            'password' => 'nullable|string',
            'role' => 'required|in:Zaměstnanec,Manažer,Administrátor',
            'phone_number' => 'nullable|numeric|digits:9',
            'street' => 'nullable|string',
            'building_number' => 'nullable|numeric|digits:5',
            'city' => 'nullable|string',
            'zip_code' => 'nullable|numeric'
        ]);

        if ($request->input('password') === '')
            $employee->update($request->except('password'));
        else {
            $request['password'] = Hash::make($request->input('password'));
            $employee->update($request->all());
        }

        if ($request->input('role') !== 'Zaměstnanec')
            $employee->syncRoles([strtolower($request->input('role'))]);

        $status = [];
        $status['title'] = 'Úspěch!';
        $status['type'] = 'success';
        $status['message'] = 'Zaměstnanec byl úspěšně upraven.';

        $request->session()->flash('status', $status);
        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param Request $request
     * @param Employee $employee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Employee $employee)
    {
        $status = [];
        $status['title'] = 'Úspěch!';
        $status['type'] = 'success';
        $status['message'] = 'Uživatel byl úspěšně odstraněn.';

        if (!$employee->hasRole('administrátor') || Auth::user()->hasRole('administrátor')) {
            Employee::destroy($employee->id);
        } else {
            $status['title'] = 'Jejda!';
            $status['type'] = 'error';
            $status['message'] = 'Pro odstranění uživatele nemáte dostatečná oprávnění.';
        }

        $request->session()->flash('status', $status);
        return redirect()->route('employees.index');
    }

    /**
     * Retrieve the data for graph rendering.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGraphData(Request $request)
    {
        if ($request->ajax())
            return response()->json([
                'label' => 'Počet zaměstnanců',
                'entries' => Employee::whereMonth('created_at', '=', Carbon::now()->month)
                    ->groupBy('date')
                    ->orderBy('date', 'DESC')
                    ->get(array(
                        DB::raw('Date(created_at) as date'),
                        DB::raw('COUNT(*) as additions')
                    ))
            ]);

        abort(404);
    }
}
