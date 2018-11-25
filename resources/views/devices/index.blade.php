@extends('layouts.dashboard')

@section('graph')
    <div class="card">
        <div class="card-header bg-dark text-white text-uppercase font-weight-bold">Počet nových zařízení denně za poslední měsíc</div>
        <div class="card-body bg-light">
            <chart></chart>
        </div>
    </div>
@endsection

@section('content')
    <div class="card mb-3">
        <table id="tableMain" class="table  m-0">
            <thead class="thead-dark">
                <tr>
                    <th></th>
                    <th scope="col">Název</th>
                    <th scope="col">Typ</th>
                    <th scope="col">Výrobce</th>
                    <th scope="col">Datum přidání</th>
                    {{--<th scope="col">Správce</th>--}}
                    <th scope="col">Akce</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devices as $device)
                    <tr>
                        <td><icon icon="plus-square" size="2x" data-toggle="collapse" data-target="#collapseRow{{ $device->id }}"></icon></td>
                        <td>{{ $device->name }}</td>
                        <td>{{ $device->type }}</td>
                        <td>{{ $device->manufacturer }}</td>
                        <td>{{ $device->created_at->format('d. m. Y') }}</td>
                        <td>
                            <icon icon="pen-square" size="2x"></icon>
                            <icon icon="times-square" size="2x"></icon>
                        </td>
                    </tr>
                    <tr id="collapseRow{{ $device->id }}" class="collapse">
                        <td colspan="4">
                            <div class="card">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Je v ČVT</th>
                                            <th>Místnost</th>
                                            <th>{{ $device->room->isInCVT() ? 'Správce' : 'Vlastník' }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if($device->room->isInCVT())
                                                <td><icon icon="check" size="2x"></icon></td>
                                            @else
                                                <td><icon icon="times" size="2x"></icon></td>
                                            @endif
                                            <td>{{ $device->room->label }}</td>
                                            <td><a href="{{ route('employees.show', $device->keeper->username) }}">{{ $device->keeper->name }}</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $devices->links() }}
@endsection
