<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the rooms.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('rooms.index')->with([
            'pageTitle' => 'Seznam místností',
        ]);
    }

    /**
     * Show the form for creating a new room.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $employees = Employee::all();
        $rooms = Room::all();

        return view('rooms.create')->with([
            'employees' => $employees,
            'pageTitle' => 'Přidat místnost',
            'rooms' => $rooms,
        ]);
    }

    /**
     * Store a newly created room in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validateRoom($request);

        $room = Room::create($request->all());

        return redirect()->route('rooms.show', ['id' => $room->id]);
    }

    /**
     * Display the specified room.
     *
     * @param Room $room
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Room $room)
    {
        return view ('rooms.show')->with([
            'room' => $room,
            'pageTitle' => 'Detail místnosti',
        ]);
    }

    /**
     * Show the form for editing the specified room.
     *
     * @param Room $room
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Room $room)
    {
        return view ('rooms.edit')->with([
            'room' => $room,
            'pageTitle' => 'Upravit místnost',
        ]);
    }

    /**
     * Update the specified room in storage.
     *
     * @param Request $request
     * @param Room $room
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Room $room)
    {
        $this->validateRoom($request);

        $room = Room::update($request->all());

        return redirect()->route('rooms.show', ['id' => $room->id]);
    }

    /**
     * Remove the specified room from storage.
     *
     * @param Room $room
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Room $room)
    {
        Room::destroy($room->id);

        return redirect()->route('rooms.index');
    }

    /**
     * Validate the specified form input.
     *
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateRoom(Request $request)
    {
        $this->validate($request, [
            'department_id' => 'required|numeric|exists:departments,id',
            'label' => 'required|unique:rooms|',
            'description' => 'required',
            'is_in_cvt' => 'required|boolean'
        ]);
    }
}
