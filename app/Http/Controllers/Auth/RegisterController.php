<?php

namespace App\Http\Controllers\Auth;

use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new employees as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect administrators after they register a new employee.
     *
     * @var string
     */
    protected $redirectTo = 'zamestnanci';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'permission:manage employees']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'department_id' => 'required|numeric|exists:departments,id',
            'room_id' => 'nullable|numeric|exists:rooms,id',
            'name' => 'required|string',
            'username' => 'required|unique:employees|string',
            'email' => 'required|unique:employees|email',
            'password' => 'required|string',
            'role' => 'required|in:Zaměstnanec,Manažer,Administrátor',
            'phone_number' => 'nullable|numeric',
            'street' => 'nullable|string',
            'building_number' => 'nullable|numeric',
            'city' => 'nullable|string',
            'zip_code' => 'nullable|numeric|size:5'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $employee = Employee::create($data);

        if ($data['role'] !== 'Zaměstnanec')
            $employee->assignRole(strtolower($data['role']));

        return redirect()->route('employees.show', ['id' => $employee->id]);
    }

    /**
     * Show the new employee registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $departments = Department::all();

        $roles = ['Zaměstnanec', 'Manažer'];

        if (Auth::user()->hasRole('administrátor'))
            array_push($roles, 'Administrátor');

        $rooms = Room::all();

        return view('auth.register')->with([
            'departments' => $departments,
            'pageTitle' => 'Přidat zaměstnance',
            'roles' => $roles,
            'rooms' => $rooms
        ]);
    }
}
