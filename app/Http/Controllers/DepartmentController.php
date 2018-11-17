<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('departments.index')->with([
            'pageTitle' => 'Seznam ústavů',
        ]);
    }

    /**
     * Show the form for creating a new department.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('departments.create')->with([
            'pageTitle' => 'Přidat ústav',
        ]);
    }

    /**
     * Store a newly created department in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validateDepartment($request);

        $department = Department::create($request->all());

        return redirect()->route('departments.show', ['id' => $department->id]);
    }

    /**
     * Display the specified department.
     *
     * @param Department $department
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Department $department)
    {
        return view ('departments.show')->with([
            'department' => $department,
            'pageTitle' => 'Detail ústavu ' . $department->shortcut,
        ]);
    }

    /**
     * Show the form for editing the specified department.
     *
     * @param Department $department
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Department $department)
    {
        return view ('departments.edit')->with([
            'department' => $department,
            'pageTitle' => 'Upravit ústav ' . $department->shortcut,
        ]);
    }

    /**
     * Update the specified department in storage.
     *
     * @param Request $request
     * @param Department $department
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Department $department)
    {
        $this->validateDepartment($request);

        $department = Department::update($request->all());

        return redirect()->route('departments.show', ['id' => $department->id]);
    }

    /**
     * Remove the specified department from storage.
     *
     * @param Department $department
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Department $department)
    {
        Department::destroy($department->id);

        return redirect()->route('departments.index');
    }

    /**
     * Validate the specified form input.
     *
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateDepartment(Request $request)
    {
        $this->validate($request, [
            'shortcut' => 'required|unique:departments|alpha',
            'name' => 'required|unique:departments|alpha',
        ]);
    }
}
