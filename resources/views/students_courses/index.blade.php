@extends('layouts.master')

@section('page-header')
    <div class="row">
        <a href="{{ route('cursos.index') }}" style="font-size: 14px;"><em class="fas fa-arrow-left"></em> Regresar </a>
    </div>
    <p style="font-size: 18px;">Nombre curso: <strong style="color: blue;">{{ $curso->name }}</strong>. Fecha inicio: <strong style="color: blue;">{{ date('d/m/Y', strtotime($curso->start_date)) }}</strong></p>
@endsection

@push('customcss')
    @include('layouts.datatablecss')
@endpush

@push('customjs')
    @include('layouts.datatablejs')
    <script>
        let tabla;

        $(function() {
            tabla = $('#tabla').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: '{!! route('estudiantes_cursos.data', $curso->id) !!}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    { data: 'cuip', name: 'cuip' },
                    { data: 'name', name: 'name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'status', name: 'status' },
                    { data: 'accion', name: 'accion', className: 'text-center', searchable: false },
                ],
                order: [[ 1, 'asc' ]],
                autoWidth: true,
                language    : {
                    url     :'{{ asset('/js/datatables/language/spanish.json') }}'
                },
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
        });

        $(document).on('click', ".eliminar", function(){
            $("#student_name").text($(this).find('.name').val());
            $("#student_id").val($(this).find('.student_id').val());
            $("#course_id").val($(this).find('.course_id').val());
            $("#modal-form").prop('action', $(this).find('.action').val());
            $("#delModal").modal('show');
        });

        $(document).on('click', ".restaurar", function(){
            $("#student_name_res").text($(this).find('.name').val());
            $("#student_id_res").val($(this).find('.student_id_res').val());
            $("#course_id_res").val($(this).find('.course_id_res').val());
            $("#modal-form-res").prop('action', $(this).find('.action').val());
            $("#resModal").modal('show');
        });
    </script>
@endpush


@section('content')
    <!-- Modal Delete -->
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="delModal" aria-hidden="true">
        <form id="modal-form" method="post">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="delModalLabel">¿Eliminar estudiante?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 text-center">
                            <i class="fas fa-exclamation-circle fa-5x text-danger"></i>
                        </div>
                        <div class="col-lg-12 text-center">
                            ¿Estás seguro que quieres eliminar el estudiante <strong id="student_name"></strong>?
                        </div>
                        <input type="hidden" id="student_id" name="student_id" value="">
                        <input type="hidden" id="course_id" name="course_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Restore -->
    <div class="modal fade" id="resModal" tabindex="-1" role="dialog" aria-labelledby="resModal" aria-hidden="true">
        <form id="modal-form-res" method="post">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="delModalLabel">¿Restaurar estudiante?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 text-center">
                            <i class="fas fa-exclamation-circle fa-5x text-warning"></i>
                        </div>
                        <div class="col-lg-12 text-center">
                            ¿Estás seguro que quieres restaurar el estudiante <strong id="student_name_res"></strong>?
                        </div>
                        <input type="hidden" id="course_id_res" name="course_id_res" value="">
                        <input type="hidden" id="student_id_res" name="student_id_res" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Restaurar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Estudiantes por curso del sistema</h4>
            <div class="panel-heading-btn">
                @can('students_courses.create')<a href="{{ route('estudiantes_cursos.create', $curso->id) }}" class="btn btn-indigo btn-sm"><i class="fas fa-user-plus"></i>&nbsp; Agregar estudiante</a>&nbsp;&nbsp;&nbsp;&nbsp;@endcan
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table width="100%" class="table table-striped" id="tabla">
                    <thead>
                        <tr>
                            <th style="width: 10%;">#</th>
                            <th style="width: 20%;">CUIP</th>
                            <th style="width: 30%;">Nombre del estudiante</th>
                            <th style="width: 10%;">Fecha de alta</th>
                            <th style="width: 10%;">Estatus</th>
                            <th style="width: 20%;">Acción</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection