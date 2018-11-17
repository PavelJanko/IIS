<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('employees.index')->with([
            'pageTitle' => 'Seznam zaměstnanců',
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
        return view ('employees.edit')->with([
            'employee' => $employee,
            'pageTitle' => 'Upravit zaměstnance' . $employee->name,
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
        $this->validateEmployee($request);

        $employee = Employee::update($request->all());

        return redirect()->route('employees.show', ['id' => $employee->id]);
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param Employee $employee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Employee $employee)
    {
        Employee::destroy($employee->id);

        return redirect()->route('employees.index');
    }
}
