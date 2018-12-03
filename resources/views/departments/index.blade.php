@extends('layouts.dashboard')

@section('graph')
    @component('components.history-chart') Počet přibylých zaměstnanců v ústavech za poslední měsíc @endcomponent
@endsection

@section('content')
    @component('components.content-table', [
        'tableHeaders' => $tableHeaders,
        'tableRows' => $tableRows,
        'collapsibleRows' => $collapsibleRows
    ]) @endcomponent
@endsection
