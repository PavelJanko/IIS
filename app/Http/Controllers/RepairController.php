<?php

namespace App\Http\Controllers;

use App\Device;
use App\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RepairController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getGraphData']);
    }

    /**
     * Display a listing of the repairs.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $repairs = Repair::orderBy('claimed_at', 'desc')->get();

        $collapsibleRows = [];

        $tableHeaders = ['', 'SSN zařízení', 'Žadatel', 'Datum žádosti', 'Stav', 'Akce'];
        $tableRows = [];

        for ($i = 0; $i < $repairs->count(); $i++) {
            $tableRows[$i] = [
                $repairs[$i]->id,
                $repairs[$i]->device->serial_number,
                $repairs[$i]->claimant->name,
                $repairs[$i]->claimed_at->format('d. m. Y'),
                $repairs[$i]->state
            ];

            $collapsibleRowTitles = ['Opravář', 'Opraveno dne', 'Správce', 'Místnost zařízení'];

            $collapsibleRowValues = [
                $repairs[$i]->repairer === null ? 'Oprava nedokončena' : $repairs[$i]->repairer->name,
                $repairs[$i]->repairer === null ? 'Oprava nedokončena' : $repairs[$i]->repaired_at->format('d. m. Y'),
                $repairs[$i]->device->keeper->name,
                $repairs[$i]->device->room === NULL ? 'Žádná' : $repairs[$i]->device->room->label,
            ];

            for ($j = 0; $j < count($collapsibleRowTitles); $j++)
                $collapsibleRows[$i][$j] = [$collapsibleRowTitles[$j], $collapsibleRowValues[$j]];
        }

        return view('repairs.index')->with([
            'collapsibleRows' => $collapsibleRows,
            'repairs' => $repairs,
            'pageTitle' => 'Seznam oprav',
            'tableHeaders' => $tableHeaders,
            'tableRows' => $tableRows,
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
     * Create a new repair claim for the specified device.
     *
     * @param Request $request
     * @param Device $device
     * @return \Illuminate\Http\RedirectResponse
     */
    public function claim(Request $request, Device $device)
    {
        Repair::create([
            'device_id' => $device->id,
            'claimant_id' => Auth::user()->id,
            'state' => 'Čekající',
            'claimed_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $status = [];
        $status['title'] = 'Úspěch!';
        $status['type'] = 'success';
        $status['message'] = 'Oprava úspěšně vytvořena.';

        $request->session()->flash('status', $status);
        return redirect()->route('devices.index');
    }

    /**
     * Mark the specified repair as in proceedings.
     *
     * @param Request $request
     * @param Repair $repair
     * @return \Illuminate\Http\RedirectResponse
     */
    public function proceed(Request $request, Repair $repair)
    {
        if ($repair->state == 'Čekající') {
            $repair->state = 'Prováděna';
            $repair->update();

            $status = [];
            $status['title'] = 'Úspěch!';
            $status['type'] = 'success';
            $status['message'] = 'Oprava je označena za prováděnou.';

            $request->session()->flash('status', $status);
        } return redirect()->route('repairs.index');
    }

    /**
     * Mark the specified repair as finished.
     *
     * @param Request $request
     * @param Repair $repair
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finish(Request $request, Repair $repair)
    {
        if ($repair->state == 'Prováděna') {
            $repair->state = 'Dokončena';
            $repair->repairer_id = Auth::user()->id;
            $repair->repaired_at = Carbon::now();
            $repair->update();

            $status = [];
            $status['title'] = 'Úspěch!';
            $status['type'] = 'success';
            $status['message'] = 'Oprava je označena za dokončenou.';

            $request->session()->flash('status', $status);
        } return redirect()->route('repairs.index');
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
                'label' => 'Počet oprav',
                'entries' => Repair::whereMonth('repaired_at', '=', Carbon::now()->month)
                    ->groupBy('date')
                    ->orderBy('date', 'DESC')
                    ->get(array(
                        DB::raw('Date(repaired_at) as date'),
                        DB::raw('COUNT(*) as additions')
                    ))
            ]);

        abort(404);
    }
}
