<?php

namespace App\Http\Controllers;

use App\Device;
use App\Employee;
use App\Room;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the devices.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('devices.index')->with([
            'pageTitle' => 'Seznam zařízení',
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
}
