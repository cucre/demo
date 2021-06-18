@extends('layouts.master')

@section('page-header')
    Gestor de usuarios
@endsection

@push('customcss')
    @include('layouts.datatablecss')
@endpush

@push('customjs')
    @include('layouts.datatablejs')
    <script>
        $(function() {
            tabla = $('#tabla').DataTable({
                processing: true,
                autoWidth: true,
                ordering: false,
                language    : {
                    url     :'{{ asset('/js/datatables/language/spanish.json') }}'
                },
                order: [[ 1, 'asc' ]],
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'excel',
                        footer: true,
                        messageTop: 'Fecha de descarga '
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'csv',
                        footer: true,
                        messageTop: 'Fecha de descarga '
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'pdf ',
                        footer: true,
                        messageTop: 'Fecha de descarga '
                    }
                ]
            });

            tabla.on( 'order.dt search.dt', function () {
                tabla.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            }).draw();
        });
    </script>
@endpush


@section('content')
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Roles del sistema</h4>
            <div class="panel-heading-btn">
                @can('roles.edit')
                    <a href="{{ route('permisos.create') }}" class="btn btn-indigo btn-sm"><i class="fas fa-user-plus"></i>&nbsp; Agregar rol</a>&nbsp;&nbsp;&nbsp;&nbsp;
                @endcan
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <table width="100%" class="table table-striped" id="tabla">
                <thead>
                    <tr>
                        <th style="width: 1%">#</th>
                        <th style="width: 15%;">Rol</th>
                        <th style="width: 15%;">Permisos Asignados</th>
                        <th style="width: 15%;">Fecha de alta</th>
                        <th style="width: 25%;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td></td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <ol>
                                @foreach ($role->permissions as $permission)
                                  <li> {{ $permission->description }} </li>
                                @endforeach
                                </ol>
                            </td>
                            <td>{{ $role->created_at->format('d-m-Y') }}</td>
                            <td>
                                @can('roles.edit')
                                    <a href="{{ route('permisos.edit', $role->id) }}" class="btn btn-green btn-sm">
                                        <i class="fas fa-pencil-alt"></i> Editar
                                    </a>
                                @endcan
                                @can('roles.delete')
                                    <form action="{{ route('permisos.destroy', $role->id) }}" 
                                        style="display: inline;" method="POST">
                                        {!! method_field('DELETE') !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button title="Eliminar" class="btn btn-sm btn-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                @endcan                               
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection