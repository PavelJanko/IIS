<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getGraphData']);
    }
    
    /**
     * Display a listing of the rooms.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $rooms = Room::orderBy('created_at', 'desc')->get();

        $collapsibleRows = [];

        $tableHeaders = ['', 'Popisek', 'Je v ČVT', 'Datum přidání', 'Datum změny', 'Akce'];
        $tableRows = [];

        for ($i = 0; $i < $rooms->count(); $i++) {
            $tableRows[$i] = [
                $rooms[$i]->id,
                '<a href="' . route("rooms.show", $rooms[$i]->id) . '">' . $rooms[$i]->label . '</a>',
                $rooms[$i]->isInCVT() ? '<icon icon="check" size="2x"></icon>' : '<icon icon="times" size="2x"></icon>',
                $rooms[$i]->created_at->format('d. m. Y'),
                $rooms[$i]->updated_at->format('d. m. Y')
            ];

            $collapsibleRowTitles = ['Ústav', 'Počet zaměstnanců'];

            $collapsibleRowValues = [
                '<a href="' . route("departments.show", $rooms[$i]->department->id) . '">' . $rooms[$i]->department->shortcut . '</a>',
                $rooms[$i]->employees->count()

            ];

            for ($j = 0; $j < count($collapsibleRowTitles); $j++)
                $collapsibleRows[$i][$j] = [$collapsibleRowTitles[$j], $collapsibleRowValues[$j]];
        }

        return view('rooms.index')->with([
            'collapsibleRows' => $collapsibleRows,
            'rooms' => $rooms,
            'pageTitle' => 'Seznam místností',
            'tableHeaders' => $tableHeaders,
            'tableRows' => $tableRows,
        ]);
    }

    /**
     * Show the form for creating a new room.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $departments = Department::all();
        $rooms = Room::all();

        return view('rooms.create')->with([
            'departments' => $departments,
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
        $request['is_in_cvt'] = $request->input('is_in_cvt') === NULL ? false : true;

        $this->validateRoom($request);

        $room = Room::create($request->all());

        $status = [];
        $status['title'] = 'Úspěch!';
        $status['type'] = 'success';
        $status['message'] = 'Místnost byla úspěšně vytvořena.';

        $request->session()->flash('status', $status);
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
        $departments = Department::all();

        return view ('rooms.edit')->with([
            'departments' => $departments,
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
        $request['is_in_cvt'] = $request->input('is_in_cvt') === NULL ? false : true;

        $this->validate($request, [
            'department_id' => 'required|numeric|exists:departments,id',
            'label' => $room->label === $request->input('label') ? 'required|regex:/[A-Z][0-9]{3}/i' : 'required|unique:rooms|regex:/[A-Z][0-9]{3}/i',
            'is_in_cvt' => 'required|boolean'
        ]);

        $room->update($request->all());

        $status = [];
        $status['title'] = 'Úspěch!';
        $status['type'] = 'success';
        $status['message'] = 'Místnost byla úspěšně upravena.';

        $request->session()->flash('status', $status);
        return redirect()->route('rooms.show', ['id' => $room->id]);
    }

    /**
     * Remove the specified room from storage.
     *
     * @param Request $request
     * @param Room $room
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Room $room)
    {
        Room::destroy($room->id);

        $status = [];
        $status['title'] = 'Úspěch!';
        $status['type'] = 'success';
        $status['message'] = 'Místnost byla úspěšně odstraněna.';

        $request->session()->flash('status', $status);
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
            'label' => 'required|unique:rooms|regex:/[A-Z][0-9]{3}/i',
            'description' => 'required',
            'is_in_cvt' => 'required|boolean'
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
                'label' => 'Počet relokací',
                'entries' => Employee::whereMonth('updated_at', '=', Carbon::now()->month)
                    ->groupBy('date')
                    ->orderBy('date', 'DESC')
                    ->get(array(
                        DB::raw('Date(updated_at) as date'),
                        DB::raw('COUNT(*) as additions')
                    ))
            ]);

        abort(404);
    }
}
