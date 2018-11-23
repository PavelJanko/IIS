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
    <div class="card pb-3">
        <table id="devicesNotInCVT" class="table">
            <thead class="thead-dark">
                <tr>
                    <th></th>
                    <th scope="col">Název</th>
                    <th scope="col">Typ</th>
                    <th scope="col">Výrobce</th>
                    <th scope="col">Datum přidání</th>
                    <th scope="col">Správce</th>
                    <th scope="col">Akce</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devices as $device)
                    <tr>
                        <td><icon icon="pen-square" size="lg" data-toggle="collapse" data-target="#collapseOne"></icon></td>
                        <td>{{ $device->name }}</td>
                        <td>{{ $device->type }}</td>
                        <td>{{ $device->manufacturer }}</td>
                        <td>{{ $device->created_at->format('d. m. Y') }}</td>
                        <td><a href="{{ route('employees.show', $device->keeper->username) }}">{{ $device->keeper->name }}</a></td>
                        <td>
                            <icon icon="pen-square" size="2x"></icon>
                            <icon icon="times-square" size="2x"></icon>
                        </td>
                    </tr>
                    <tr id="collapseOne" class="collapse" v-if="rowShow">
                        <td colspan="8">
                            <table class="table">
                                <tr>
                                    <td>Test</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $('#devicesNotInCVT').DataTable({
            columnDefs: [
                { orderable: false, targets: [0, 6] }
            ],
            info: false,
            language: {
                'sEmptyTable':     'Tabulka neobsahuje žádná data',
                'sInfo':           'Zobrazuji _START_ až _END_ z celkem _TOTAL_ záznamů',
                'sInfoEmpty':      'Zobrazuji 0 až 0 z 0 záznamů',
                'sInfoFiltered':   '(filtrováno z celkem _MAX_ záznamů)',
                'sInfoPostFix':    '',
                'sInfoThousands':  ' ',
                'sLengthMenu':     'Zobraz záznamů _MENU_',
                'sLoadingRecords': 'Načítám...',
                'sProcessing':     'Provádím...',
                'sSearch':         'Hledat:',
                'sZeroRecords':    'Žádné záznamy nebyly nalezeny',
                'oPaginate': {
                    'sFirst':    'První',
                    'sLast':     'Poslední',
                    'sNext':     'Další',
                    'sPrevious': 'Předchozí'
                },
                'oAria': {
                    'sSortAscending':  ': aktivujte pro řazení sloupce vzestupně',
                    'sSortDescending': ': aktivujte pro řazení sloupce sestupně'
                }
            },
            lengthChange: false,
            order: [[ 4, 'desc']],
            searching: false,
            select: false
        });
    </script>
@endsection
