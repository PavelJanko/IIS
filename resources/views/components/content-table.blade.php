@unless(explode('.', Route::currentRouteName())[0] == 'repairs')
    <a class="btn btn-primary font-weight-bold mb-4 text-uppercase" href="{{ route(explode('.', Route::currentRouteName())[0] . '.create') }}" role="button">
        <icon class="mr-1" icon="plus-square"></icon> Přidat
    </a>
@endunless
<div class="card mb-3">
    <table id="tableMain" class="table  m-0">
        <thead class="thead-dark">
            <tr>
                @foreach($tableHeaders as $tableHeader)
                    <th>{{ $tableHeader }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($tableRows as $tableColumns)
                <tr>
                    <td><icon icon="plus-square" size="2x" data-toggle="collapse" data-target="#collapseRow{{ $tableColumns[0] }}"></icon></td>
                    @foreach($tableColumns as $tableColumn)
                        @unless($loop->first)
                            <td>{!! $tableColumn !!}</td>
                        @endunless
                    @endforeach
                    <td>
                        @if(explode('.', Route::currentRouteName())[0] == 'devices')
                            <a href="{{ route('repairs.claim', $tableColumns[0]) }}"><icon icon="cogs" size="2x"></icon></a>
                        @endif
                        @if(explode('.', Route::currentRouteName())[0] == 'repairs')
                            @if($tableColumns[4] == 'Čekající')
                                <a href="{{ route('repairs.proceed', $tableColumns[0]) }}"><icon icon="hand-point-down" size="2x"></icon></a>
                            @elseif($tableColumns[4] == 'Prováděna')
                                <a href="{{ route('repairs.finish', $tableColumns[0]) }}"><icon icon="check-square" size="2x"></icon></a>
                            @endif
                        @else
                            <a href="{{ route(explode('.', Route::currentRouteName())[0] . '.edit', $tableColumns[0]) }}"><icon icon="pen-square" size="2x"></icon></a>
                        @endif
                        <form class="d-inline" action="{{ route(explode('.', Route::currentRouteName())[0] . '.destroy', $tableColumns[0]) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <icon class="delete-dialog" icon="times-square" size="2x"></icon>
                        </form>
                    </td>
                </tr>
                <tr id="collapseRow{{ $tableColumns[0] }}" class="collapse">
                    <td>
                        <div class="card col-6 py-3">
                            <dl class="row m-0">
                                @foreach($collapsibleRows[$loop->index] as $collapsibleRow => $collapsibleRowPairs)
                                    <dt class="col-6 py-1">{{ $collapsibleRowPairs[0] }}</dt>
                                    <dt class="col-6 py-1">{!! $collapsibleRowPairs[1] !!}</dt>
                                @endforeach
                            </dl>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('scripts')
    <script>
        $('.delete-dialog').click((e) => {
            e.preventDefault();

            swal({
                title: 'Opravdu?',
                text: 'Jste si jisti, že chcete položku odstranit?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ano',
                cancelButtonText: 'Ne'
            }).then((result) => {
                if (result.value)
                    $(e.target).closest('form').submit();
            });
        });
    </script>
@endsection
