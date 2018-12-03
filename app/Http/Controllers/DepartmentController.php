<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getGraphData']);
    }
    
    /**
     * Display a listing of the departments.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $departments = Department::orderBy('created_at', 'desc')->get();

        $collapsibleRows = [];

        $tableHeaders = ['', 'Název', 'Zkratka', 'Datum založení', 'Datum změny', 'Akce'];
        $tableRows = [];

        for ($i = 0; $i < $departments->count(); $i++) {
            $tableRows[$i] = [
                $departments[$i]->id,
                $departments[$i]->name,
                $departments[$i]->shortcut,
                $departments[$i]->created_at->format('d. m. Y'),
                $departments[$i]->updated_at->format('d. m. Y')
            ];

            $collapsibleRowTitles = ['Počet zaměstnanců', 'Počet místností'];

            $collapsibleRowValues = [
                $departments[$i]->employees->count(),
                $departments[$i]->rooms->count()
            ];

            for ($j = 0; $j < count($collapsibleRowTitles); $j++)
                $collapsibleRows[$i][$j] = [$collapsibleRowTitles[$j], $collapsibleRowValues[$j]];
        }

        return view('departments.index')->with([
            'collapsibleRows' => $collapsibleRows,
            'departments' => $departments,
            'pageTitle' => 'Seznam ústavů',
            'tableHeaders' => $tableHeaders,
            'tableRows' => $tableRows,
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

        $status = [];
        $status['title'] = 'Úspěch!';
        $status['type'] = 'success';
        $status['message'] = 'Ústav byl úspěšně vytvořen.';

        $request->session()->flash('status', $status);
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
        $this->validate($request, [
            'shortcut' => $department->shortcut === $request->input('shortcut') ? 'required|alpha|regex:/[A-Z]{4}/i' : 'required|unique:departments|alpha|regex:/[A-Z]{4}/i',
            'name' => $department->name === $request->input('name') ? 'required|string' : 'required|string|unique:departments',
        ]);

        $department->update($request->all());

        $status = [];
        $status['title'] = 'Úspěch!';
        $status['type'] = 'success';
        $status['message'] = 'Ústav byl úspěšně upraven.';

        $request->session()->flash('status', $status);
        return redirect()->route('departments.show', ['id' => $department->id]);
    }

    /**
     * Remove the specified department from storage.
     *
     * @param Request $request
     * @param Department $department
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Department $department)
    {
        Department::destroy($department->id);

        $status = [];
        $status['title'] = 'Úspěch!';
        $status['type'] = 'success';
        $status['message'] = 'Ústav byl úspěšně upraven.';

        $request->session()->flash('status', $status);
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
            'shortcut' => 'required|unique:departments|string',
            'name' => 'required|unique:departments|string',
        ]);
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
