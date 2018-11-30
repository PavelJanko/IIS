<?php

namespace App\Http\Controllers;

use App\Device;
use App\Employee;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    /**
     * Display a listing of the devices.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $devices = Device::orderBy('created_at', 'desc')->get();

        $collapsibleRows = [];

        $tableHeaders = ['', 'Název', 'Typ', 'Výrobce', 'Datum přidání', 'Akce'];
        $tableRows = [];

        for ($i = 0; $i < $devices->count(); $i++) {
            $tableRows[$i] = [
                $devices[$i]->id,
                $devices[$i]->name,
                $devices[$i]->type,
                $devices[$i]->manufacturer,
                $devices[$i]->created_at->format('d. m. Y')
            ];

            $collapsibleRowTitles = ['Je v ČVT', 'Místnost', $devices[$i]->room->isInCVT() ? 'Správce' : 'Vlastník', 'Počet dokončených oprav'];

            $collapsibleRowValues = [
                $devices[$i]->room->isInCVT() ?
                    '<icon icon="check" size="2x"></icon>' :
                    '<icon icon="times" size="2x"></icon>',
                $devices[$i]->room->label,
                '<a href="' . route("employees.show", $devices[$i]->keeper->username) . '">' . $devices[$i]->keeper->name . '</a>' .
                '<a href="' . route("departments.show", $devices[$i]->keeper->department->shortcut) . '"> (' . $devices[$i]->keeper->department->shortcut . ')</a>',
                $devices[$i]->repairs->where('state', '=', 'Dokončena')->count()
            ];

            for ($j = 0; $j < count($collapsibleRowTitles); $j++)
                $collapsibleRows[$i][$j] = [$collapsibleRowTitles[$j], $collapsibleRowValues[$j]];
        }

        return view('devices.index')->with([
            'collapsibleRows' => $collapsibleRows,
            'devices' => $devices,
            'pageTitle' => 'Seznam zařízení',
            'tableHeaders' => $tableHeaders,
            'tableRows' => $tableRows,
        ]);
    }

    /**
     * Show the form for creating a new device.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $employees = Employee::all();
        $rooms = Room::all();

        return view('devices.create')->with([
            'employees' => $employees,
            'pageTitle' => 'Přidat zařízení',
            'rooms' => $rooms,
        ]);
    }

    /**
     * Store a newly created device in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validateDevice($request);

        $device = Device::create($request->all());

        return redirect()->route('devices.show', ['id' => $device->id]);
    }

    /**
     * Display the specified device.
     *
     * @param Device $device
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Device $device)
    {
        return view ('devices.show')->with([
            'device' => $device,
            'pageTitle' => 'Detail zařízení ' . $device->serial_number,
        ]);
    }

    /**
     * Show the form for editing the specified device.
     *
     * @param Device $device
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Device $device)
    {
        return view ('devices.edit')->with([
            'device' => $device,
            'pageTitle' => 'Upravit zařízení ' . $device->serial_number,
        ]);
    }

    /**
     * Update the specified device in storage.
     *
     * @param Request $request
     * @param Device $device
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Device $device)
    {
        $this->validateDevice($request);

        $device = Device::update($request->all());

        return redirect()->route('devices.show', ['id' => $device->id]);
    }

    /**
     * Remove the specified device from storage.
     *
     * @param Device $device
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Device $device)
    {
        Device::destroy($device->id);

        return redirect()->route('devices.index');
    }

    /**
     * Validate the specified form input.
     *
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateDevice(Request $request)
    {
        $this->validate($request, [
            'keeper_id' => 'required|numeric|exists:employees,id',
            'room_id' => 'numeric|exists:rooms,id',
            'serial_number' => 'required|unique:devices|alpha_num',
            'name' => 'required|string',
            'type' => 'required|string',
            'manufacturer' => 'required|string',
        ]);
    }

    public function getGraphData()
    {
        return response()->json(Device::whereMonth('created_at', '=', Carbon::now()->month)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as additions')
            )));
    }
}
