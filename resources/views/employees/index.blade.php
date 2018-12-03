@extends('layouts.dashboard')

@section('graph')
    @component('components.history-chart') Počet nových zaměstnanců denně za poslední měsíc @endcomponent
@endsection

@section('content')
    @component('components.content-table', [
        'tableHeaders' => $tableHeaders,
        'tableRows' => $tableRows,
        'collapsibleRows' => $collapsibleRows
    ]) @endcomponent
@endsection
