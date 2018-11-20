<?php

namespace App\Http\Controllers\Auth;

use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Room;
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
        $this->middleware('guest');
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
            'room_id' => 'numeric|exists:rooms,id',
            'name' => 'required|string',
            'username' => 'required|unique:employees|string',
            'email' => 'required|unique:employees|string',
            'password' => 'required|string|confirmed',
            'phone_number' => 'numeric',
            'street' => 'string',
            'building_number' => 'numeric',
            'city' => 'string',
            'zip_code' => 'numeric|size:5'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Employee
     */
    protected function create(array $data)
    {
        return Employee::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Show the new employee registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $departments = Department::all();
        $rooms = Room::all();

        return view('auth.register')->with([
            'departments' => $departments,
            'pageTitle' => 'Přidat zaměstnance',
            'rooms' => $rooms
        ]);
    }
}
