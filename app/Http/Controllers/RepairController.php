<?php

namespace App\Http\Controllers;

use App\Repair;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    /**
     * Display a listing of the repairs.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('repairs.index')->with([
            'pageTitle' => 'Seznam oprav',
        ]);
    }

    /**
     * Show the form for creating a new repair.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $employees = Employee::all();
        $rooms = Room::all();

        return view('repairs.create')->with([
            'employees' => $employees,
            'pageTitle' => 'Přidat opravu',
            'rooms' => $rooms,
        ]);
    }

    /**
     * Store a newly created repair in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validateRepair($request);

        $repair = Repair::create($request->all());

        return redirect()->route('repairs.show', ['id' => $repair->id]);
    }

    /**
     * Display the specified repair.
     *
     * @param Repair $repair
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Repair $repair)
    {
        return view ('repairs.show')->with([
            'repair' => $repair,
            'pageTitle' => 'Detail opravy',
        ]);
    }

    /**
     * Show the form for editing the specified repair.
     *
     * @param Repair $repair
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Repair $repair)
    {
        return view ('repairs.edit')->with([
            'repair' => $repair,
            'pageTitle' => 'Upravit opravu',
        ]);
    }

    /**
     * Update the specified repair in storage.
     *
     * @param Request $request
     * @param Repair $repair
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Repair $repair)
    {
        $this->validateRepair($request);

        $repair = Repair::update($request->all());

        return redirect()->route('repairs.show', ['id' => $repair->id]);
    }

    /**
     * Remove the specified repair from storage.
     *
     * @param Repair $repair
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Repair $repair)
    {
        Repair::destroy($repair->id);

        return redirect()->route('repairs.index');
    }

    /**
     * Validate the specified form input.
     *
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateRepair(Request $request)
    {
        $this->validate($request, [
            'device_id' => 'required|numeric|exists:devices,id',
            'claimant_id' => 'required|numeric|exists:employees,id',
            'repairer_id' => 'required|numeric|exists:employees,id',
            'repaired_at' => 'date',
            'state' => 'required|string',
        ]);
    }
}
